<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $leads = Lead::count();
        $approvedLeadsCount = Lead::where('status', 'approved')->count();
        $deliveredLeadsCount = Lead::where('status', 'delivered')->count();
        $pendingLeadsCount = Lead::where('status', 'pending')->count();

        $amounts = Transaction::groupBy('seller_id')
            ->selectRaw('seller_id, sum(amount) as totalAmount')
            ->orderByDesc('totalAmount')
            ->limit(10)
            ->get();

        $sellerIds = $amounts->pluck('seller_id');

        $sellers = Seller::whereIn('id', $sellerIds)
            ->with('transactions')
            ->get()
            ->sortByDesc(function ($seller) use ($amounts) {
                return $amounts->where('seller_id', $seller->id)->first()->totalAmount;
            });

        // charts

        $minMaxDates = Lead::selectRaw('MIN(order_date) as min_date, MAX(order_date) as max_date')->first();

        $startDate = $minMaxDates->min_date;
        $endDate = now()->toDateString();

        // Generate all dates within the range
        $allDates = [];
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $allDates[] = $currentDate;
            $currentDate = date('Y-m-d', strtotime($currentDate . ' + 1 day'));
        }

        // Execute the query to get counts for existing dates
        $existingCounts = Lead::selectRaw('order_date, COUNT(*) as count')
            ->groupBy('order_date')
            ->pluck('count', 'order_date')
            ->toArray();

        // Fill in missing counts with zero
        $leads_count = [];
        foreach ($allDates as $date) {
            $count = isset($existingCounts[$date]) ? $existingCounts[$date] : 0;
            $leads_count[] = (object)['date' => $date, 'count' => $count];
        }
// orders
// Charts for Orders
        $minMaxOrderDates = Order::selectRaw('MIN(created_at) as min_date, MAX(created_at) as max_date')->first();
        $startOrderDate = Carbon::parse($minMaxOrderDates->min_date)->format('Y-m-d');
        $endOrderDate = now()->toDateString();

// Generate all dates within the range for orders
        $allOrderDates = [];
        $currentOrderDate = $startOrderDate;
        while ($currentOrderDate <= $endOrderDate) {
            $allOrderDates[] = $currentOrderDate;
            $currentOrderDate = date('Y-m-d', strtotime($currentOrderDate . ' + 1 day'));
        }

// Execute the query to get counts for existing dates
        $existingOrderCounts = Order::selectRaw('DATE(created_at) as order_date, COUNT(*) as count')
            ->where('shipment_status', 'approved')
            ->groupBy('order_date')
            ->pluck('count', 'order_date')
            ->toArray();

// Fill in missing counts with zero for orders
        $orders_count = [];
        foreach ($allOrderDates as $date) {
            $count = isset($existingOrderCounts[$date]) ? $existingOrderCounts[$date] : 0;
            $orders_count[] = (object)['date' => $date, 'count' => $count];
        }
        
        return view('admin.dashboard', compact('leads', 'approvedLeadsCount', 'deliveredLeadsCount', 'pendingLeadsCount', 'sellers', 'leads_count', 'orders_count'));
    }
}

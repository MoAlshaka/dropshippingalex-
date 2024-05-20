<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $leads = Lead::where('seller_id', auth()->guard('seller')->id())->count();
        $approvedLeadsCount = Lead::where('seller_id', auth()->guard('seller')->id())->where('status', 'approved')->count();
        $deliveredLeadsCount = Lead::where('seller_id', auth()->guard('seller')->id())->where('status', 'delivered')->count();
        $revenue = Transaction::where('seller_id', auth()->guard('seller')->id())->sum('amount');
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

        // Get the minimum and maximum dates for the leads associated with the authenticated seller
        $minMaxDates = Lead::selectRaw('MIN(order_date) as min_date, MAX(order_date) as max_date')
            ->where('seller_id', auth()->guard('seller')->id())
            ->first();

        $startDate = $minMaxDates->min_date;
        $endDate = now()->toDateString();

// Generate all dates within the range
        $allDates = [];
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $allDates[] = $currentDate;
            $currentDate = date('Y-m-d', strtotime($currentDate . ' + 1 day'));
        }

// Execute the query to get counts for existing dates, filtered by the authenticated seller
        $existingCounts = Lead::selectRaw('order_date, COUNT(*) as count')
            ->where('seller_id', auth()->guard('seller')->id())
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
// Get the minimum and maximum dates for the orders associated with the authenticated seller
        $minMaxOrderDates = Order::selectRaw('MIN(created_at) as min_date, MAX(created_at) as max_date')
            ->where('seller_id', auth()->guard('seller')->id())
            ->first();

        $startOrderDate = Carbon::parse($minMaxOrderDates->min_date)->format('Y-m-d');


        $endOrderDate = now()->toDateString();

// Generate all dates within the range for orders
        $allOrderDates = [];
        $currentOrderDate = $startOrderDate;
        while ($currentOrderDate <= $endOrderDate) {
            $allOrderDates[] = $currentOrderDate;
            $currentOrderDate = date('Y-m-d', strtotime($currentOrderDate . ' + 1 day'));
        }

// Execute the query to get counts for existing dates, filtered by the authenticated seller
        $existingOrderCounts = Order::selectRaw('DATE(created_at) as order_date, COUNT(*) as count')
            ->where('seller_id', auth()->guard('seller')->id())
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


        return view('seller.dashboard', compact('leads', 'approvedLeadsCount', 'deliveredLeadsCount', 'revenue', 'sellers', 'leads_count', 'orders_count'));
    }
}

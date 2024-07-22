<?php

namespace App\Http\Controllers\Seller;

use App\Models\Lead;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AffiliateProduct;
use App\Http\Controllers\Controller;
use App\Models\SharedProduct;

class DashboardController extends Controller
{
    public function index()
    {
        $leads = Lead::where('seller_id', auth()->guard('seller')->id())->count();
        $approvedLeadsCount = Lead::where('seller_id', auth()->guard('seller')->id())->where('status', 'approved')->count();
        $deliveredLeadsCount = Lead::where('seller_id', auth()->guard('seller')->id())->where('status', 'delivered')->count();
        $revenue = Seller::where('id', auth()->guard('seller')->id())->pluck('revenue')->first();

        $sellers = Seller::orderby('revenue', 'desc')->limit(10)->get();
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

    public function filter(Request $request)
    {
        // Get top sellers and their transaction amounts
        $sellers = Seller::orderby('revenue', 'desc')->limit(10)->get();

        // Initialize lead-related variables
        $leads = $approvedLeadsCount = $deliveredLeadsCount = $revenue = 0;
        $leads_count = [];
        $orders_count = [];

        if ($request->has('date') && $request->date != '') {
            $dates = explode(' - ', $request->date);

            if (count($dates) === 2) {
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();

                $leads = Lead::where('seller_id', auth()->guard('seller')->id())->whereBetween('order_date', [$start_date, $end_date])->count();
                $approvedLeadsCount = Lead::where('seller_id', auth()->guard('seller')->id())->where('status', 'approved')->whereBetween('order_date', [$start_date, $end_date])->count();
                $deliveredLeadsCount = Lead::where('seller_id', auth()->guard('seller')->id())->where('status', 'delivered')->whereBetween('order_date', [$start_date, $end_date])->count();
                $revenue = Transaction::where('seller_id', auth()->guard('seller')->id())->whereBetween('created_at', [$start_date, $end_date])->sum('amount');

                // Generate all dates within the range for leads
                $allDates = [];
                $currentDate = $start_date->copy();
                while ($currentDate->lte($end_date)) {
                    $allDates[] = $currentDate->format('Y-m-d');
                    $currentDate->addDay();
                }

                // Get counts for existing dates for leads
                $existingCounts = Lead::where('seller_id', auth()->guard('seller')->id())->whereBetween('order_date', [$start_date, $end_date])
                    ->selectRaw('order_date, COUNT(*) as count')
                    ->groupBy('order_date')
                    ->pluck('count', 'order_date')
                    ->toArray();

                // Fill in missing counts with zero for leads
                foreach ($allDates as $date) {
                    $count = isset($existingCounts[$date]) ? $existingCounts[$date] : 0;
                    $leads_count[] = (object)['date' => $date, 'count' => $count];
                }

                // Generate all dates within the range for orders
                $allOrderDates = [];
                $currentOrderDate = $start_date->copy();
                while ($currentOrderDate->lte($end_date)) {
                    $allOrderDates[] = $currentOrderDate->format('Y-m-d');
                    $currentOrderDate->addDay();
                }

                // Get counts for existing dates for orders
                $existingOrderCounts = Order::where('seller_id', auth()->guard('seller')->id())->selectRaw('DATE(created_at) as order_date, COUNT(*) as count')
                    ->where('shipment_status', 'approved')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->groupBy('order_date')
                    ->pluck('count', 'order_date')
                    ->toArray();

                // Fill in missing counts with zero for orders
                foreach ($allOrderDates as $date) {
                    $count = isset($existingOrderCounts[$date]) ? $existingOrderCounts[$date] : 0;
                    $orders_count[] = (object)['date' => $date, 'count' => $count];
                }
            }
        }

        return view('seller.dashboard', compact('leads', 'approvedLeadsCount', 'deliveredLeadsCount', 'revenue', 'sellers', 'leads_count', 'orders_count'));
    }
}

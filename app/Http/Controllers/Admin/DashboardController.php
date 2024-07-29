<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lead;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Invoice;
use App\Models\Revenue;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {

        $allrevenues = Revenue::all();
        foreach ($allrevenues as $revenue) {
            if ($revenue->revenue >= 50 && Carbon::now()->isSunday()) {
                $flag = Invoice::create([
                    'seller_id' => $revenue->seller_id,
                    'revenue' => $revenue->revenue,
                    'date' => date('Y-m-d'),
                    'crated_at' => date('Y-m-d'),
                    'status' => 'unpaid',
                ]);
                if ($flag) {
                    $revenue->update(['revenue' => 0]);
                }
            }
        }




        $leads = Lead::count();
        $approvedLeadsCount = Lead::where('status', 'confirmed')->count();
        $deliveredLeadsCount = Order::where('shipment_status', 'delivered')->count();
        $pendingLeadsCount = Lead::where('status', 'pending')->count();
        $revenue = 0;
        $revenues = Invoice::select('seller_id', DB::raw('SUM(revenue) as revenue'))
            ->groupBy('seller_id')
            ->orderBy('revenue', 'desc')
            ->limit(10)
            ->get();

        $sellers = [];
        foreach ($revenues as $revenue) {
            $seller = Seller::findOrFail($revenue->seller_id);
            $sellers[] = ['seller' => $seller, 'revenue' => $revenue->revenue];
        }
        $admins =  Admin::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Owner');
        })->get();
        $allSellers = Seller::orderby('id', 'desc')->get();



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

        return view('admin.dashboard', compact('leads', 'pendingLeadsCount', 'approvedLeadsCount', 'deliveredLeadsCount', 'revenue', 'sellers', 'leads_count', 'orders_count', 'allSellers', 'admins'));
    }


    public function filter(Request $request)
    {
        // Get top sellers and their transaction amounts
        $sellers = Seller::orderby('revenue', 'desc')->limit(10)->get();

        // Initialize lead-related variables
        $leads = $approvedLeadsCount = $deliveredLeadsCount = $revenue = 0;
        $leads_count = [];
        $orders_count = [];

        $sellerIds = [];
        if ($request->has('manger_id')) {
            foreach ($request->manger_id as $manger_id) {

                $manger = Admin::findOrFail($manger_id);
                foreach ($manger->sellers as $seller) {
                    array_push($sellerIds, $seller->id);
                }
            }
        }

        if ($request->has('date') && $request->date != '') {
            $dates = explode(' - ', $request->date);

            if (count($dates) === 2) {
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            }
        }
        $leads = Lead::whereBetween('order_date', [$start_date, $end_date])->orWhereIn('seller_id', $sellerIds)
            ->orWhere('seller_id', $request->seller_id)->count();
        $approvedLeadsCount = Lead::where('status', 'approved')->orWhereBetween('order_date', [$start_date, $end_date])->orWhereIn('seller_id', $sellerIds)
            ->orWhere('seller_id', $request->seller_id)->count();
        $deliveredLeadsCount = Lead::where('status', 'delivered')->orWhereBetween('order_date', [$start_date, $end_date])->orWhereIn('seller_id', $sellerIds)
            ->orWhere('seller_id', $request->seller_id)->count();
        $revenue = Revenue::orWhereIn('seller_id', $sellerIds)
            ->orWhereIn('seller_id', $request->seller_id)
            ->sum('revenue');

        // Generate all dates within the range for leads
        $allDates = [];
        $currentDate = $start_date->copy();
        while ($currentDate->lte($end_date)) {
            $allDates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // Get counts for existing dates for leads
        $existingCounts = Lead::whereBetween('order_date', [$start_date, $end_date])
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
        $existingOrderCounts = Order::selectRaw('DATE(created_at) as order_date, COUNT(*) as count')
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
        $admins = Admin::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Owner');
        })->get();


        return view('admin.dashboard', compact('leads', 'approvedLeadsCount', 'deliveredLeadsCount', 'revenue', 'sellers', 'leads_count', 'orders_count', 'admins'));
    }
}

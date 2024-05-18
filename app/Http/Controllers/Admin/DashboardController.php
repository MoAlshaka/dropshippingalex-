<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Seller;
use App\Models\Transaction;
use Illuminate\Http\Request;
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


        //return $leads_count;
        return view('admin.dashboard', compact('leads', 'approvedLeadsCount', 'deliveredLeadsCount', 'pendingLeadsCount', 'sellers', 'leads_count'));
    }
}

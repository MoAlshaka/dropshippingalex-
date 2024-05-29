<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Lead;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {

        $orders = Order::where('seller_id', auth()->guard('seller')->user()->id)->count();
        $countries = Country::all();
        $leads = Lead::where('seller_id', auth()->guard('seller')->user()->id)->count();

        $under_process = 0;
        $confirmed = 0;
        $canceled = 0;
        $fulfilled = 0;
        $shipped = 0;
        $delivered = 0;
        $returned = 0;
        $confirmed_rate = 0;
        $delivered_rate = 0;

        $under_process = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'pending')->count();
        $confirmed = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'approved')->count();
        $canceled = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'canceled')->count();
        $fulfilled = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'fulfilled')->count();
        $shipped = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'shipping')->count();
        $delivered = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'delivered')->count();
        $returned = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'returned')->count();

        if ($orders > 0) {
            $confirmed_rate = intval(($confirmed / $orders) * 100);
            $delivered_rate = intval(($delivered / $orders) * 100);
        }
        return view('seller.reports.index', compact('leads', 'under_process', 'confirmed', 'canceled', 'fulfilled', 'shipped', 'delivered', 'returned', 'countries', 'confirmed_rate', 'delivered_rate'));
    }

    public function filter_country($countryId)
    {
        $orders = Order::where('seller_id', auth()->guard('seller')->user()->id)->count();
        $countries = Country::all();
        $country = Country::findOrFail($countryId);
        $leads = Lead::where('seller_id', auth()->guard('seller')->user()->id)->where('warehouse', $country->name)->count();
        $under_process = Order::where('seller_id', auth()->guard('seller')->user()->id)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'pending')->count();
        $confirmed = Order::where('seller_id', auth()->guard('seller')->user()->id)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'approved')->count();
        $canceled = Order::where('seller_id', auth()->guard('seller')->user()->id)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'canceled')->count();
        $fulfilled = Order::where('seller_id', auth()->guard('seller')->user()->id)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'fulfilled')->count();
        $shipped = Order::where('seller_id', auth()->guard('seller')->user()->id)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'shipping')->count();
        $delivered = Order::where('seller_id', auth()->guard('seller')->user()->id)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'delivered')->count();
        $returned = Order::where('seller_id', auth()->guard('seller')->user()->id)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'returned')->count();

        if ($orders > 0) {
            $confirmed_rate = intval(($confirmed / $orders) * 100);
            $delivered_rate = intval(($delivered / $orders) * 100);
        }

        return view('seller.reports.index', compact('leads', 'under_process', 'confirmed', 'canceled', 'fulfilled', 'shipped', 'delivered', 'returned', 'countries', 'confirmed_rate', 'delivered_rate'));
    }

    public function filter(Request $request)
    {
        $orders = Order::where('seller_id', auth()->guard('seller')->user()->id)->count();
        $countries = Country::all();


        // Initialize variables to default values
        $under_process = 0;
        $confirmed = 0;
        $canceled = 0;
        $fulfilled = 0;
        $shipped = 0;
        $delivered = 0;
        $returned = 0;
        $confirmed_rate = 0;
        $delivered_rate = 0;

        if ($request->has('date') && $request->date != '') {
            $dates = explode(' - ', $request->date);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();

                $leads = Lead::where('seller_id', auth()->guard('seller')->user()->id)->whereBetween('order_date', [$start_date, $end_date])->count();

                $under_process = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'pending')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $confirmed = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'approved')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $canceled = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'canceled')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $fulfilled = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'fulfilled')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $shipped = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'shipping')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $delivered = Order::where('shipment_status', 'delivered')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $returned = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'returned')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();
            }
        }

        // Calculate rates only if there are orders to avoid division by zero
        if ($orders > 0) {
            $confirmed_rate = intval(($confirmed / $orders) * 100);
            $delivered_rate = intval(($delivered / $orders) * 100);
        }

        return view('seller.reports.index', compact(
            'leads',
            'under_process',
            'confirmed',
            'canceled',
            'fulfilled',
            'shipped',
            'delivered',
            'returned',
            'countries',
            'confirmed_rate',
            'delivered_rate'
        ));
    }
}

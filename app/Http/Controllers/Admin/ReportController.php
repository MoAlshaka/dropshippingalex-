<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Lead;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $orders = Order::count();
        $countries = Country::all();
        $leads = Lead::count();
        $under_process = Order::where('shipment_status', 'pending')->count();
        $confirmed = Order::where('shipment_status', 'approved')->count();
        $canceled = Order::where('shipment_status', 'canceled')->count();
        $fulfilled = Order::where('shipment_status', 'fulfilled')->count();
        $shipped = Order::where('shipment_status', 'shipping')->count();
        $delivered = Order::where('shipment_status', 'delivered')->count();
        $returned = Order::where('shipment_status', 'returned')->count();

        $confirmed_rate = intval(($confirmed / $orders) * 100);
        $delivered_rate = intval(($delivered / $orders) * 100);
        return view('admin.reports.index', compact('leads', 'under_process', 'confirmed', 'canceled', 'fulfilled', 'shipped', 'delivered', 'returned', 'countries', 'confirmed_rate', 'delivered_rate'));
    }

    public function filter_country($countryId)
    {
        $orders = Order::count();
        $countries = Country::all();
        $country = Country::findOrFail($countryId);
        $leads = Lead::count();
        $under_process = Order::whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'pending')->count();
        $confirmed = Order::whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'approved')->count();
        $canceled = Order::whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'canceled')->count();
        $fulfilled = Order::whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'fulfilled')->count();
        $shipped = Order::whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'shipping')->count();
        $delivered = Order::whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'delivered')->count();
        $returned = Order::whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'returned')->count();

        $confirmed_rate = intval(($confirmed / $orders) * 100);
        $delivered_rate = intval(($delivered / $orders) * 100);

        return view('admin.reports.index', compact('leads', 'under_process', 'confirmed', 'canceled', 'fulfilled', 'shipped', 'delivered', 'returned', 'countries', 'confirmed_rate', 'delivered_rate'));
    }

    public function filter(Request $request)
    {
        $orders = Order::count();
        $countries = Country::all();
        $leads = Lead::count();

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
                $start_date = $dates[0];
                $end_date = $dates[1];

                $under_process = Order::whereBetween('crated_at', [$start_date, $end_date])->where('shipment_status', 'pending')->count();
                $confirmed = Order::whereBetween('crated_at', [$start_date, $end_date])->where('shipment_status', 'approved')->count();
                $canceled = Order::whereBetween('crated_at', [$start_date, $end_date])->where('shipment_status', 'canceled')->count();
                $fulfilled = Order::whereBetween('crated_at', [$start_date, $end_date])->where('shipment_status', 'fulfilled')->count();
                $shipped = Order::whereBetween('crated_at', [$start_date, $end_date])->where('shipment_status', 'shipping')->count();
                $delivered = Order::whereBetween('crated_at', [$start_date, $end_date])->where('shipment_status', 'delivered')->count();
                $returned = Order::whereBetween('crated_at', [$start_date, $end_date])->where('shipment_status', 'returned')->count();

                // Ensure there are orders to avoid division by zero

            }
        }

        $confirmed_rate = intval(($confirmed / $orders) * 100);
        $delivered_rate = intval(($delivered / $orders) * 100);


        return view('admin.reports.index', compact('leads', 'under_process', 'confirmed', 'canceled', 'fulfilled', 'shipped', 'delivered', 'returned', 'countries', 'confirmed_rate', 'delivered_rate'));
    }

}

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
}

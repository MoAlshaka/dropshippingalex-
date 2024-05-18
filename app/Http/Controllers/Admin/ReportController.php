<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $leads = Lead::count();
        $under_process = Order::where('shipment_status', 'pending')->count();
        $confirmed = Order::where('shipment_status', 'approved')->count();
        $canceled = Order::where('shipment_status', 'canceled')->count();
        $fulfilled = Order::where('shipment_status', 'fulfilled')->count();
        $shipped = Order::where('shipment_status', 'shipping')->count();
        $delivered = Order::where('shipment_status', 'delivered')->count();
        $returned = Order::where('shipment_status', 'returned')->count();

        return view('admin.reports.index', compact('leads', 'under_process', 'confirmed', 'canceled', 'fulfilled', 'shipped', 'delivered', 'returned'));
    }
}

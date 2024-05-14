<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Shippingdetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders=Order::orderBy('id', 'DESC')->paginate(COUNT);
        return view('admin.orders.index', compact('orders'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order=Order::findorfail($id);
        return view('admin.orders.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order=Order::findorfail($id);
        return view('admin.orders.edit',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'shipping_details' => 'required',
            'shipment_status' => 'required',
            'payment_status' => 'required',
            'payment_type' => 'required'
        ]);

        $order=Order::findorfail($id);

        $order->update([
            'shipment_status' => $request->shipment_status,
            'payment_status' => $request->payment_status,
            'payment_type' => $request->payment_type,
            'calls' => $request->calls,
        ]);

        Shippingdetail::create([
            'details' => $request->shipping_details,

            'order_id' => $order->id,
        ]);
        return redirect()->route('orders.index')->with(['Update'=>'Update Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Order::destroy($id);
            return redirect()->route('orders.index')->with(['Delete' => 'Delete successfully']);
        } catch (\Throwable $th) {
            return redirect()->route('orders.index')->with(['Warning' => 'لا يمكن حذف هذا الحقل لانه مرتيط بحقول أخرى']);
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'ref' => 'required|max:50'
        ]);
        $orders=Order::where('store_reference',$request->ref)->orderBy('id', 'DESC')->paginate(COUNT);
        return view('admin.orders.index', compact('orders'));
    }
    public function filter(Request $request)
    {

        $query = Order::query();

        if ($request->has('created_at') && $request->created_at != '') {
            $dates = explode(' - ', $request->created_at);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->format('Y-m-d');
                $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->format('Y-m-d');

                // Apply the whereBetween condition on the 'order_date' column
                $query->whereBetween('order_date', [$start_date, $end_date]);
            }
        }



        if ($request->has('warehouse') && $request->warehouse != '') {
            $query->orWhereIn('warehouse',  $request->warehouse );
        }

        if ($request->has('country') && $request->country != '') {
            $query->orWhereIn('customer_country', $request->country);
        }
        if ($request->has('status') && $request->status != '') {
            $query->orWhereIn('status', $request->status);
        }
        if ($request->has('type') && $request->type != '') {
            $query->orWhereIn('type', $request->type);
        }

        $leads = $query->orderBy('id', 'DESC')->paginate(COUNT);// Replace 10 with your desired number of items per page
        $countries=Country::all();
        $status = Lead::distinct()->pluck('status');
        $types = Lead::distinct()->pluck('type');
        $shippment_status = Order::distinct()->pluck('shippment_status');
        $payment_status = Order::distinct()->pluck('payment_status');
        return view('admin.leads.index', compact('leads','countries','status','types','shippment_status','payment_status'));

    }
}

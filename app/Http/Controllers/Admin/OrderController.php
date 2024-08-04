<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lead;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Country;
use App\Models\Revenue;
use Illuminate\Http\Request;

use App\Models\SharedProduct;
use App\Models\AffiliateProduct;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Carbon\Carbon;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:All Orders')->only('index');
        $this->middleware('permission:Edit Order')->only(['edit', 'update']);
        $this->middleware('permission:Delete Orders')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $types = Lead::distinct()->pluck('type');
        $shipment_status = Order::distinct()->pluck('shipment_status');
        $payment_status = Order::distinct()->pluck('payment_status');
        return view('admin.orders.index', compact('orders', 'countries', 'types', 'shipment_status', 'payment_status'));
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
        $order = Order::findorfail($id);
        $country = Country::where('name', $order->lead->warehouse)->first();
        $sharedproduct = SharedProduct::where('sku', $order->lead->item_sku)->first();
        $affiliateproduct = AffiliateProduct::where('sku', $order->lead->item_sku)->first();
        if (isset($sharedproduct)) {
            $product = $sharedproduct;
        } else {
            $product = $affiliateproduct;
        }

        return view('admin.orders.show', compact('order', 'product', 'country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findorfail($id);
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'shipment_status' => 'required|max:50',
            'payment_status' => 'required|max:50',
            'payment_type' => 'required|max:50',
        ]);
        $order = Order::findorfail($id);
        $old_status = $order->shipment_status;
        $flag = $order->update([
            'shipment_status' => $request->shipment_status,
            'payment_status' => $request->payment_status,
            'payment_type' => $request->payment_type,
            'calls' => $request->calls,
        ]);


        if ($flag) {
            if ($order->shipment_status == 'delivered' && $order->shipment_status !== $old_status) {
                $lead = Lead::findorfail($order->lead_id);  // Use find() for efficiency
                $revenue = Revenue::where('seller_id', $order->seller_id)->first();

                if ($revenue) {
                    if ($revenue->revenue >= 50 && Carbon::now()->isSunday()) {
                        $flag = Invoice::create([
                            'seller_id' => $order->seller_id,
                            'revenue' => $revenue->revenue,
                            'date' => date('Y-m-d'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'status' => 'unpaid',
                        ]);
                        if ($flag) {
                            $revenue->update(['revenue' => 0]);
                        }
                    }
                }
                if ($lead->type == 'commission') {
                    $product = AffiliateProduct::where('sku', $lead->item_sku)->first();

                    if ($product) {
                        if (!empty($revenue)) {
                            $revenue->update([
                                'revenue' => $revenue->revenue + ($product->commission * $lead->quantity),
                            ]);
                        } else {
                            Revenue::create([
                                'revenue' => ($product->commission * $lead->quantity),
                                'seller_id' => $order->seller_id,
                                'lead_id' => $order->lead_id,
                                'order_id' => $order->id,
                                'date' => date('Y-m-d'),
                            ]);
                        }
                    }
                } else {
                    $product = SharedProduct::where('sku', $lead->item_sku)->first();

                    $country = Country::where('name', $lead->warehouse)->first();

                    if ($product) {
                        $money = $lead->total / $lead->quantity;
                        $x = (($money - $product->unit_cost) * $lead->quantity) - $country->shipping_cost;
                        if ($x < 0) {
                            $x = 0;
                        }
                        if (!empty($revenue)) {
                            $revenue->update([
                                'revenue' => $revenue->revenue + $x,
                            ]);
                        } else {
                            Revenue::create([
                                'revenue' => $x,
                                'seller_id' => $order->seller_id,
                                'lead_id' => $order->lead_id,
                                'order_id' => $order->id,
                                'date' => date('Y-m-d'),
                            ]);
                        }
                    }
                }
            }
        }
        // $orders = Order::where('seller_id', auth()->user()->id)->get();
        // $revenue = 0;
        // if ($orders->isNotEmpty()) {
        //     foreach ($orders as $order) {
        //         if ($order->shipment_status == 'delivered') {
        //             $lead = Lead::find($order->lead_id);  // Use find() for efficiency
        //             if ($lead) {
        //                 if ($lead->type == 'commission') {
        //                     $product = AffiliateProduct::where('sku', $lead->item_sku)->first();
        //                     if ($product) {
        //                         $revenue += $product->commission;
        //                     }
        //                 } else {
        //                     $product = SharedProduct::where('sku', $lead->item_sku)->first();
        //                     if ($product) {
        //                         $money = $lead->total / $lead->quantity;
        //                         // if($lead->Currency ==){

        //                         // }
        //                         $revenue += ($money - $product->unit_cost);
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

        // Seller::where('id', auth()->user()->id)->update([
        //     'revenue' => $revenue,
        // ]);

        return redirect()->route('orders.index')->with(['Update' => 'Update Successfully']);
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
        $leads = Lead::where('store_reference', $request->ref)->pluck('id');
        $orders = Order::whereIn('lead_id', $leads)->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $types = Lead::distinct()->pluck('type');
        $shipment_status = Order::distinct()->pluck('shipment_status');
        $payment_status = Order::distinct()->pluck('payment_status');
        return view('admin.orders.index', compact('orders', 'countries',  'types', 'shipment_status', 'payment_status'));
    }
    public function filter(Request $request)
    {

        $query = Order::query();
        $start_date = '';
        $end_date = '';
        if ($request->has('created_at') && $request->created_at != '') {
            $dates = explode(' - ', $request->created_at);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->format('Y-m-d');
                $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->format('Y-m-d');
                $leads = Lead::whereBetween('order_date', [$start_date, $end_date] ?? [])->pluck('id');
                // Apply the whereBetween condition on the 'order_date' column
                $query->WhereIn('lead_id',  $leads);
            }
        }



        if ($request->has('warehouse') && $request->warehouse != '') {
            $leads = Lead::WhereIn('warehouse', $request->warehouse ?? [])->pluck('id');
            $query->WhereIn('lead_id',  $leads);
        }

        if ($request->has('country') && $request->country != '') {
            $leads = Lead::WhereIn('customer_country', $request->country ?? [])->pluck('id');
            $query->WhereIn('lead_id', $leads);
        }
        if ($request->has('status') && $request->status != '') {
            $leads = Lead::WhereIn('status', $request->status ?? [])->pluck('id');
            $query->WhereIn('lead_id', $leads);
        }
        if ($request->has('type') && $request->type != '') {
            $leads = Lead::WhereIn('type', $request->type ?? [])->pluck('id');
            $query->WhereIn('lead_id', $leads);
        }
        if ($request->has('shipment_status') && $request->shipment_status != '') {
            $query->WhereIn('shipment_status', $request->shipment_status ?? []);
        }
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->WhereIn('payment_status', $request->payment_status ?? []);
        }

        $orders = $query->orderBy('id', 'DESC')->paginate(COUNT); // Replace 10 with your desired number of items per page
        $countries = Country::all();

        $types = Lead::distinct()->pluck('type');
        $shipment_status = Order::distinct()->pluck('shipment_status');
        $payment_status = Order::distinct()->pluck('payment_status');
        return view('admin.orders.index', compact('orders', 'countries', 'types', 'shipment_status', 'payment_status'));
    }
}

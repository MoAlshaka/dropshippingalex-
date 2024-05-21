<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProduct;
use App\Models\Country;
use App\Models\Lead;
use App\Models\Order;
use App\Models\SharedProduct;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('seller_id', auth()->guard('seller')->user()->id)->orderBy('id', 'DESC')->paginate(COUNT);
        $countries = Country::all();
        $status = Lead::distinct()->pluck('status');
        $types = Lead::distinct()->pluck('type');
        $shipment_status = Order::distinct()->pluck('shipment_status');
        $payment_status = Order::distinct()->pluck('payment_status');
        return view('seller.orders.index', compact('orders', 'countries', 'status', 'types', 'shipment_status', 'payment_status'));


    }

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
        return view('seller.orders.show', compact('order', 'product', 'country'));
    }

//    public function filter(Request $request)
//    {
//
//        $query = Order::where('seller_id', auth()->guard('seller')->user()->id);
//
//        if ($request->has('created_at') && $request->created_at != '') {
//            $dates = explode(' - ', $request->created_at);
//
//            // Ensure both start and end dates are available
//            if (count($dates) === 2) {
//                $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->format('Y-m-d');
//                $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->format('Y-m-d');
//                $leads = Lead::whereBetween('order_date', [$start_date, $end_date])->pluck('id');
//                // Apply the whereBetween condition on the 'order_date' column
//                $query->orWhereIn('lead_id', $leads);
//            }
//        }
//
//
//        if ($request->has('warehouse') && $request->warehouse != '') {
//            $leads = Lead::whereIn('warehouse', $request->warehouse)->pluck('id');
//            $query->orWhereIn('lead_id', $leads);
//        }
//
//        if ($request->has('country') && $request->country != '') {
//            $leads = Lead::whereIn('customer_country', $request->country)->pluck('id');
//            $query->orWhereIn('lead_id', $leads);
//        }
//        if ($request->has('status') && $request->status != '') {
//            $leads = Lead::whereIn('status', $request->status)->pluck('id');
//            $query->orWhereIn('lead_id', $leads);
//        }
//        if ($request->has('type') && $request->type != '') {
//            $leads = Lead::whereIn('type', $request->type)->pluck('id');
//            $query->orWhereIn('lead_id', $leads);
//        }
//        if ($request->has('shipment_status') && $request->shipment_status != '') {
//            $query->orWhereIn('shipment_status', $request->type);
//        }
//        if ($request->has('payment_status') && $request->payment_status != '') {
//            $query->orWhereIn('payment_status', $request->payment_status);
//        }
//
//        $orders = $query->orderBy('id', 'DESC')->paginate(COUNT);
//        $countries = Country::all();
//        $status = Lead::distinct()->pluck('status');
//        $types = Lead::distinct()->pluck('type');
//        $shipment_status = Order::distinct()->pluck('shipment_status');
//        $payment_status = Order::distinct()->pluck('payment_status');
//        return view('seller.orders.index', compact('orders', 'countries', 'status', 'types', 'shipment_status', 'payment_status'));
//
//    }
    public function filter(Request $request)
    {
        $query = Order::where('seller_id', auth()->guard('seller')->user()->id);

        if ($request->has('created_at') && $request->created_at != '') {
            $dates = explode(' - ', $request->created_at);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay()->format('Y-m-d H:i:s');
                $end_date = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay()->format('Y-m-d H:i:s');
                $leads = Lead::whereBetween('order_date', [$start_date, $end_date])->pluck('id');
                // Apply the whereIn condition on the 'lead_id' column
                $query->whereIn('lead_id', $leads);
            }
        }

        if ($request->has('warehouse') && $request->warehouse != '') {
            $leads = Lead::whereIn('warehouse', $request->warehouse)->pluck('id');
            $query->whereIn('lead_id', $leads);
        }

        if ($request->has('country') && $request->country != '') {
            $leads = Lead::whereIn('customer_country', $request->country)->pluck('id');
            $query->whereIn('lead_id', $leads);
        }

        if ($request->has('status') && $request->status != '') {
            $leads = Lead::whereIn('status', $request->status)->pluck('id');
            $query->whereIn('lead_id', $leads);
        }

        if ($request->has('type') && $request->type != '') {
            $leads = Lead::whereIn('type', $request->type)->pluck('id');
            $query->whereIn('lead_id', $leads);
        }

        if ($request->has('shipment_status') && $request->shipment_status != '') {
            $query->whereIn('shipment_status', $request->shipment_status);
        }

        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->whereIn('payment_status', $request->payment_status);
        }

        $orders = $query->orderBy('id', 'DESC')->paginate(COUNT);

        $countries = Country::all();
        $status = Lead::distinct()->pluck('status');
        $types = Lead::distinct()->pluck('type');
        $shipment_status = Order::distinct()->pluck('shipment_status');
        $payment_status = Order::distinct()->pluck('payment_status');

        return view('seller.orders.index', compact('orders', 'countries', 'status', 'types', 'shipment_status', 'payment_status'));
    }

}

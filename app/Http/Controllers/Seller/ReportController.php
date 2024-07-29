<?php

namespace App\Http\Controllers\Seller;

use Carbon\Carbon;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\SharedProduct;
use App\Models\AffiliateProduct;
use App\Http\Controllers\Controller;

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
        $balance = 0;
        $shipped = 0;
        $delivered = 0;
        $returned = 0;
        $confirmed_rate = 0;
        $delivered_rate = 0;

        $under_process = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'pending')->count();
        $confirmed = Lead::where('seller_id', auth()->guard('seller')->user()->id)->where('status', 'confirmed')->count();
        $canceled = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'canceled')->count();
        $balance = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'balance')->count();
        $shipped = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'shipping')->count();
        $delivered = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'delivered')->count();
        $returned = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'returned')->count();

        if ($orders > 0) {
            $confirmed_rate = intval(($confirmed / $orders) * 100);
            $delivered_rate = intval(($delivered / $orders) * 100);
        }
        return view('seller.reports.index', compact('leads', 'under_process', 'confirmed', 'canceled', 'balance', 'shipped', 'delivered', 'returned', 'countries', 'confirmed_rate', 'delivered_rate'));
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
        $confirmed = Lead::where('seller_id', auth()->guard('seller')->user()->id)->where('warehouse', $country->name)->where('status', 'confirmed')->count();

        $canceled = Order::where('seller_id', auth()->guard('seller')->user()->id)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'canceled')->count();
        $balance = Order::where('seller_id', auth()->guard('seller')->user()->id)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'balance')->count();
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

        return view('seller.reports.index', compact('leads', 'under_process', 'confirmed', 'canceled', 'balance', 'shipped', 'delivered', 'returned', 'countries', 'confirmed_rate', 'delivered_rate'));
    }

    public function filter(Request $request)
    {
        $orders = Order::where('seller_id', auth()->guard('seller')->user()->id)->count();
        $countries = Country::all();


        // Initialize variables to default values
        $under_process = 0;
        $confirmed = 0;
        $canceled = 0;
        $balance = 0;
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

                $confirmed = Lead::where('seller_id', auth()->guard('seller')->user()->id)->where('status', 'confirmed')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $canceled = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'canceled')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $balance = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'balance')
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
            'balance',
            'shipped',
            'delivered',
            'returned',
            'countries',
            'confirmed_rate',
            'delivered_rate'
        ));
    }

    public function affiliate_filter()
    {
        // Initialize variables
        $leads = 0;
        $under_process = 0;
        $confirmed = 0;
        $delivered = 0;
        $confirmed_rate = 0;
        $total_commission = 0;
        $average_commission = 0;
        $highestCommissions = [];

        // Get seller ID
        $sellerId = auth()->guard('seller')->user()->id;

        // Retrieve leads for the seller
        $leads = Lead::where('seller_id', $sellerId)->where('type', 'commission')->count();
        $lead_ids = Lead::where('seller_id', $sellerId)->where('type', 'commission')->pluck('id');
        // Retrieve order statuses for the leads
        $under_process = Order::where('seller_id', $sellerId)->whereIn('lead_id', $lead_ids)->where('shipment_status', 'pending')->count();
        $confirmed = Lead::where('seller_id', $sellerId)->whereIn('id', $lead_ids)->where('status', 'confirmed')->count();
        $delivered = Order::where('seller_id', $sellerId)->whereIn('lead_id', $lead_ids)->where('shipment_status', 'delivered')->count();

        // Calculate confirmed rate
        if ($leads > 0) {
            $confirmed_rate = intval(($confirmed / $leads) * 100);
        }

        // Retrieve confirmed leads and their SKUs
        $lead_confirmed = Lead::where('seller_id', $sellerId)->whereIn('id', $lead_ids)->where('status', 'confirmed')->pluck('id');
        $lead_sku = Lead::whereIn('id', $lead_confirmed)->pluck('item_sku')->unique();

        // Retrieve affiliate product commissions


        // Calculate total commission
        $orders = Order::whereIn('lead_id', $lead_confirmed)->where('shipment_status', 'delivered')->get();
        $total_commission = 0;
        $total_quantity = 0;
        if ($orders) {
            foreach ($orders as $order) {
                $quantity = Lead::where('id', $order->lead_id)->pluck('quantity')->first();
                $total_commission += AffiliateProduct::where('sku', $order->lead->item_sku)->pluck('commission')->first()  * $quantity;
                $total_quantity += $quantity;
            }
        }




        // Calculate highest commissions
        $lead_skus = $lead_sku->unique();

        $highest_commissions = AffiliateProduct::whereIn('sku', $lead_skus)->orderByDesc('commission')->limit(5)->get();
        foreach ($highest_commissions as $highest_commission) {
            $leadspros = Lead::where('item_sku', $highest_commission->sku)->pluck('id');

            $total_order_count = Order::whereIn('lead_id', $leadspros)->where('shipment_status', 'delivered')->count();

            if ($total_order_count > 0) {
                $highestCommissions[] = [
                    'highest_commission' => $highest_commission,
                    'amount' => $total_order_count * $highest_commission->commission
                ];
            }
        }

        // Retrieve the highest commission product
        $highest_commission = AffiliateProduct::whereIn('sku', $lead_skus)->orderByDesc('commission')->first();

        // Calculate average commission
        if ($confirmed > 0) {
            $average_commission = $total_commission / $total_quantity;
        }

        // Return view with compacted variables
        return view('seller.reports.affiliate', compact(
            'leads',
            'under_process',
            'confirmed',
            'delivered',
            'total_commission',
            'highestCommissions',
            'highest_commission',
            'average_commission',
            'confirmed_rate'
        ));
    }


    public function marketplace()
    {
        // Get the authenticated seller ID
        $sellerId = auth()->guard('seller')->user()->id;

        // Retrieve unique affiliate SKUs for the seller
        $affiliateSkus = Lead::where('seller_id', $sellerId)->where('type', 'commission')->distinct()->pluck('item_sku');

        // Retrieve affiliate products
        $affiliateProducts = AffiliateProduct::whereIn('sku', $affiliateSkus)->get();

        // Initialize products array
        $products = [];

        // Process affiliate products
        foreach ($affiliateProducts as $affiliateProduct) {
            $sku = $affiliateProduct->sku;

            // Retrieve leads and orders for the current SKU
            $leadsCount = Lead::where('seller_id', $sellerId)->where('item_sku', $sku)->count();
            $leadIds = Lead::where('seller_id', $sellerId)->where('item_sku', $sku)->pluck('id');

            // Retrieve order counts by status
            $confirmed = Lead::whereIn('id', $leadIds)->where('status', 'confirmed')->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->count();
            $balance = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'balance')->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->count();

            // Calculate rates
            $confirmed_rate = $leadsCount > 0 ? intval(($confirmed / $leadsCount) * 100) : 0;
            $delivered_rate = $leadsCount > 0 ? intval(($delivered / $leadsCount) * 100) : 0;

            // Add affiliate product data to products array
            $products[] = [
                'type' => 'affiliate',
                'product' => $affiliateProduct,
                'leads' => $leadsCount,
                'confirmed' => $confirmed,
                'cancelled' => $cancelled,
                'balance' => $balance,
                'shipped' => $shipped,
                'delivered' => $delivered,
                'returned' => $returned,
                'confirmed_rate' => $confirmed_rate,
                'delivered_rate' => $delivered_rate
            ];
        }

        // Retrieve unique shared SKUs for the seller
        $sharedSkus = Lead::where('seller_id', $sellerId)->where('type', 'regular')->distinct()->pluck('item_sku');

        // Retrieve shared products
        $sharedProducts = SharedProduct::whereIn('sku', $sharedSkus)->get();

        // Process shared products
        foreach ($sharedProducts as $sharedProduct) {
            $sku = $sharedProduct->sku;

            // Retrieve leads and orders for the current SKU
            $leadsCount = Lead::where('item_sku', $sku)->count();
            $leadIds = Lead::where('seller_id', $sellerId)->where('item_sku', $sku)->pluck('id');

            // Retrieve order counts by status
            $confirmed = Lead::whereIn('id', $leadIds)->where('status', 'confirmed')->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->count();
            $balance = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'balance')->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->count();

            // Calculate rates
            $confirmed_rate = $leadsCount > 0 ? intval(($confirmed / $leadsCount) * 100) : 0;
            $delivered_rate = $leadsCount > 0 ? intval(($delivered / $leadsCount) * 100) : 0;

            // Add shared product data to products array
            $products[] = [
                'type' => 'shared',
                'product' => $sharedProduct,
                'leads' => $leadsCount,
                'confirmed' => $confirmed,
                'cancelled' => $cancelled,
                'balance' => $balance,
                'shipped' => $shipped,
                'delivered' => $delivered,
                'returned' => $returned,
                'confirmed_rate' => $confirmed_rate,
                'delivered_rate' => $delivered_rate
            ];
        }

        // Sort the products array by leads count in descending order
        usort($products, function ($a, $b) {
            return $b['leads'] <=> $a['leads'];
        });

        // Return view with compacted variables
        return view('seller.reports.marketplace', compact('products'));
    }
    public function markplace_filter_date(Request $request)
    {

        // Get the authenticated seller ID
        $sellerId = auth()->guard('seller')->user()->id;

        if ($request->has('date') && $request->date != '') {
            $dates = explode(' - ', $request->date);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            }
        }

        // Retrieve unique affiliate SKUs for the seller
        $affiliateSkus = Lead::where('seller_id', $sellerId)->where('type', 'commission')->whereBetween('created_at', [$start_date, $end_date])->distinct()->pluck('item_sku');

        // Retrieve affiliate products
        $affiliateProducts = AffiliateProduct::whereIn('sku', $affiliateSkus)->get();

        // Initialize products array
        $products = [];

        // Process affiliate products
        foreach ($affiliateProducts as $affiliateProduct) {
            $sku = $affiliateProduct->sku;

            // Retrieve leads and orders for the current SKU
            $leadsCount = Lead::where('seller_id', $sellerId)->where('item_sku', $sku)->count();
            $leadIds = Lead::where('seller_id', $sellerId)->where('item_sku', $sku)->pluck('id');

            // Retrieve order counts by status
            $confirmed = Lead::whereIn('id', $leadIds)->where('status', 'confirmed')->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->count();
            $balance = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'balance')->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->count();

            // Calculate rates
            $confirmed_rate = $leadsCount > 0 ? intval(($confirmed / $leadsCount) * 100) : 0;
            $delivered_rate = $leadsCount > 0 ? intval(($delivered / $leadsCount) * 100) : 0;

            // Add affiliate product data to products array
            $products[] = [
                'type' => 'affiliate',
                'product' => $affiliateProduct,
                'leads' => $leadsCount,
                'confirmed' => $confirmed,
                'cancelled' => $cancelled,
                'balance' => $balance,
                'shipped' => $shipped,
                'delivered' => $delivered,
                'returned' => $returned,
                'confirmed_rate' => $confirmed_rate,
                'delivered_rate' => $delivered_rate
            ];
        }

        // Retrieve unique shared SKUs for the seller
        $sharedSkus = Lead::where('seller_id', $sellerId)->where('type', 'regular')->whereBetween('created_at', [$start_date, $end_date])->distinct()->pluck('item_sku');

        // Retrieve shared products
        $sharedProducts = SharedProduct::whereIn('sku', $sharedSkus)->get();

        // Process shared products
        foreach ($sharedProducts as $sharedProduct) {
            $sku = $sharedProduct->sku;

            // Retrieve leads and orders for the current SKU
            $leadsCount = Lead::where('item_sku', $sku)->count();
            $leadIds = Lead::where('item_sku', $sku)->pluck('id');

            // Retrieve order counts by status
            $confirmed = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'approved')->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->count();
            $balance = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'balance')->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->count();

            // Calculate rates
            $confirmed_rate = $leadsCount > 0 ? intval(($confirmed / $leadsCount) * 100) : 0;
            $delivered_rate = $leadsCount > 0 ? intval(($delivered / $leadsCount) * 100) : 0;

            // Add shared product data to products array
            $products[] = [
                'type' => 'shared',
                'product' => $sharedProduct,
                'leads' => $leadsCount,
                'confirmed' => $confirmed,
                'cancelled' => $cancelled,
                'balance' => $balance,
                'shipped' => $shipped,
                'delivered' => $delivered,
                'returned' => $returned,
                'confirmed_rate' => $confirmed_rate,
                'delivered_rate' => $delivered_rate
            ];
        }

        // Sort the products array by leads count in descending order
        usort($products, function ($a, $b) {
            return $b['leads'] <=> $a['leads'];
        });

        // Return view with compacted variables
        return view('seller.reports.marketplace', compact('products'));
    }


    public function affiliate_filter_date(Request $request)
    {
        // Initialize variables
        $leads = 0;
        $under_process = 0;
        $confirmed = 0;
        $delivered = 0;
        $confirmed_rate = 0;
        $total_commission = 0;
        $average_commission = 0;
        $highestCommissions = [];

        // Get seller ID
        $sellerId = auth()->guard('seller')->user()->id;

        // Retrieve leads for the seller

        $lead_ids = Lead::where('seller_id', $sellerId)->where('type', 'commission')->pluck('id');
        // Retrieve order statuses for the leads

        if ($request->has('date') && $request->date != '') {
            $dates = explode(' - ', $request->date);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            }
        }

        $leads = Lead::where('seller_id', $sellerId)->where('type', 'commission')->whereBetween('created_at', [$start_date, $end_date])->count();


        $under_process = Order::where('seller_id', $sellerId)->whereIn('lead_id', $lead_ids)->where('shipment_status', 'pending')->whereBetween('created_at', [$start_date, $end_date])->count();
        $confirmed = Lead::where('seller_id', $sellerId)->whereIn('id', $lead_ids)->where('status', 'confirmed')->whereBetween('created_at', [$start_date, $end_date])->count();
        $delivered = Order::where('seller_id', $sellerId)->whereIn('lead_id', $lead_ids)->where('shipment_status', 'delivered')->whereBetween('created_at', [$start_date, $end_date])->count();

        // Calculate confirmed rate
        if ($leads > 0) {
            $confirmed_rate = intval(($confirmed / $leads) * 100);
        }

        // Retrieve confirmed leads and their SKUs
        $lead_confirmed = Lead::where('seller_id', $sellerId)->whereIn('id', $lead_ids)->where('status', 'confirmed')->whereBetween('created_at', [$start_date, $end_date])->pluck('id');
        $lead_sku = Lead::whereIn('id', $lead_confirmed)->pluck('item_sku')->unique();

        // Retrieve affiliate product commissions


        // Calculate total commission
        $orders = Order::whereIn('lead_id', $lead_confirmed)->where('shipment_status', 'delivered')->get();
        $total_commission = 0;
        if ($orders) {
            foreach ($orders as $order) {
                $quantity = Lead::where('id', $order->lead_id)->pluck('quantity')->first();
                $total_commission += AffiliateProduct::where('sku', $order->lead->item_sku)->pluck('commission')->first()  * $quantity;
            }
        }




        // Calculate highest commissions
        $lead_skus = $lead_sku->unique();

        $highest_commissions = AffiliateProduct::whereIn('sku', $lead_skus)->orderByDesc('commission')->limit(5)->get();
        foreach ($highest_commissions as $highest_commission) {
            $leadspros = Lead::where('item_sku', $highest_commission->sku)->pluck('id');

            $total_order_count = Order::whereIn('lead_id', $leadspros)->where('shipment_status', 'delivered')->count();

            if ($total_order_count > 0) {
                $highestCommissions[] = [
                    'highest_commission' => $highest_commission,
                    'amount' => $total_order_count * $highest_commission->commission
                ];
            }
        }

        // Retrieve the highest commission product
        $highest_commission = AffiliateProduct::whereIn('sku', $lead_skus)->orderByDesc('commission')->first();

        // Calculate average commission
        if ($confirmed > 0) {
            $average_commission = $total_commission / $confirmed;
        }

        // Return view with compacted variables
        return view('seller.reports.affiliate', compact(
            'leads',
            'under_process',
            'confirmed',
            'delivered',
            'total_commission',
            'highestCommissions',
            'highest_commission',
            'average_commission',
            'confirmed_rate'
        ));
    }
}

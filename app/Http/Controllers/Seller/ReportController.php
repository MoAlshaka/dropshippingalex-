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

        $under_process = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'pending')->count();
        $confirmed = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'approved')->count();
        $canceled = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'canceled')->count();
        $balance = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'balance')->count();
        $shipped = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'shipping')->count();
        $delivered = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'delivered')->count();
        $returned = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'returned')->count();

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
        $confirmed = Order::where('seller_id', auth()->guard('seller')->user()->id)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'approved')->count();
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

                $confirmed = Order::where('seller_id', auth()->guard('seller')->user()->id)->where('shipment_status', 'approved')
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
        $confirmed = Order::where('seller_id', $sellerId)->whereIn('lead_id', $lead_ids)->where('shipment_status', 'approved')->count();
        $delivered = Order::where('seller_id', $sellerId)->whereIn('lead_id', $lead_ids)->where('shipment_status', 'delivered')->count();

        // Calculate confirmed rate
        if ($leads > 0) {
            $confirmed_rate = intval(($confirmed / $leads) * 100);
        }

        // Retrieve confirmed leads and their SKUs
        $lead_confirmed = Order::where('seller_id', $sellerId)->whereIn('lead_id', $lead_ids)->where('shipment_status', 'approved')->pluck('lead_id');
        $lead_sku = Lead::whereIn('id', $lead_confirmed)->pluck('item_sku');

        // Retrieve affiliate product commissions
        $affilates = AffiliateProduct::whereIn('sku', $lead_sku)->pluck('comission');

        // Calculate total commission
        $total_commission = $affilates->sum();

        // Calculate highest commissions
        $lead_skus = $lead_sku->unique();
        $highest_commissions = AffiliateProduct::whereIn('sku', $lead_skus)->orderByDesc('comission')->limit(5)->get();

        foreach ($highest_commissions as $highest_commission) {
            $leadspros = Lead::where('item_sku', $highest_commission->sku)->pluck('id');

            $total_order_count = Order::whereIn('lead_id', $leadspros)->where('shipment_status', 'approved')->count();

            if ($total_order_count > 0) {
                $highestCommissions[] = [
                    'highest_commission' => $highest_commission,
                    'amount' => $total_order_count * $highest_commission->comission
                ];
            }
        }

        // Retrieve the highest commission product
        $highest_commission = AffiliateProduct::whereIn('sku', $lead_skus)->orderByDesc('comission')->first();

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
    public function markplace_filter_date(Request $request)
    {
        $request->validate([
            'date' => 'required'
        ]);
        $affiliateSkus = Lead::where('type', 'commission')->distinct()->pluck('item_sku');

        $affiliateProducts = AffiliateProduct::whereIn('sku', $affiliateSkus)->get();


        $products = [];


        foreach ($affiliateProducts as $affiliateProduct) {

            $leadsCount = Lead::where('item_sku', $affiliateProduct->sku)->count();


            $leadIds = Lead::where('item_sku', $affiliateProduct->sku)->pluck('id');
            if ($request->has('date') && $request->date != '') {
                $dates = explode(' - ', $request->date);

                // Ensure both start and end dates are available
                if (count($dates) === 2) {
                    $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                    $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
                }
            }

            $confirmed = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'approved')->whereBetween('created_at', [$start_date, $end_date])->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->whereBetween('created_at', [$start_date, $end_date])->count();
            $balance = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'balance')->whereBetween('created_at', [$start_date, $end_date])->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->whereBetween('created_at', [$start_date, $end_date])->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->whereBetween('created_at', [$start_date, $end_date])->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->whereBetween('created_at', [$start_date, $end_date])->count();
            if ($leadsCount > 0) {
                $confirmed_rate = $leadsCount > 0 ? intval(($confirmed / $leadsCount) * 100) : 0;
                $delivered_rate = $leadsCount > 0 ? intval(($delivered / $leadsCount) * 100) : 0;
            }
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


        $sharedSkus = Lead::where('type', 'regular')->distinct()->pluck('item_sku');


        $sharedProducts = SharedProduct::whereIn('sku', $sharedSkus)->get();

        foreach ($sharedProducts as $sharedProduct) {

            $leadsCount = Lead::where('item_sku', $sharedProduct->sku)->count();


            $leadIds = Lead::where('item_sku', $sharedProduct->sku)->pluck('id');

            $confirmed = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'approved')->whereBetween('created_at', [$start_date, $end_date])->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->whereBetween('created_at', [$start_date, $end_date])->count();
            $balance = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'balance')->whereBetween('created_at', [$start_date, $end_date])->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->whereBetween('created_at', [$start_date, $end_date])->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->whereBetween('created_at', [$start_date, $end_date])->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->whereBetween('created_at', [$start_date, $end_date])->count();
            if ($leadsCount > 0) {


                $confirmed_rate = $leadsCount > 0 ? intval(($confirmed / $leadsCount) * 100) : 0;
                $delivered_rate = $leadsCount > 0 ? intval(($delivered / $leadsCount) * 100) : 0;
            }

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






        return view('seller.reports.marketplace', compact('products'));
    }

    public function affiliate_filter_date(Request $request)
    {
        $leads = 0;
        $under_process = 0;
        $confirmed = 0;
        $highest_comissions = 0;
        $highest_comission = 0;
        $average_commission = 0;
        $delivered = 0;
        $confirmed_rate = 0;



        $leads = Lead::where('type', 'commission')->count();
        $lead_ids = Lead::where('type', 'commission')->pluck('id');

        if ($request->has('date') && $request->date != '') {
            $dates = explode(' - ', $request->date);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            }
        }

        $under_process = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'pending')->whereBetween('created_at', [$start_date, $end_date])->count();
        $confirmed = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'approved')->whereBetween('created_at', [$start_date, $end_date])->count();
        $delivered = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'delivered')->whereBetween('created_at', [$start_date, $end_date])->count();

        $lead_confirmed = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'approved')->whereBetween('created_at', [$start_date, $end_date])->pluck('lead_id');

        $lead_sku = Lead::whereIn('id', $lead_confirmed)->pluck('item_sku');
        if ($leads > 0) {

            $confirmed_rate = $leads > 0 ? intval(($confirmed / $leads) * 100) : 0;
        }

        $affilates = [];

        foreach ($lead_sku as  $sku) {
            $id = AffiliateProduct::where('sku', $sku)->pluck('id');
            array_push($affilates, $id);
        }

        $total_commission = 0;

        foreach ($affilates as $affilate) {
            $commission = AffiliateProduct::where('id', $affilate)->pluck('comission');

            $total_commission = $total_commission + $commission[0];
        }


        $lead_skus = Lead::whereIn('id', $lead_confirmed)->pluck('item_sku')->unique();

        $highest_commissions = AffiliateProduct::whereIn('sku', $lead_skus)->orderByDesc('comission')->limit(5)->get();

        $highestCommissions = [];
        foreach ($highest_commissions as $highest_commission) {

            $leadspros = Lead::where('item_sku', $highest_commission->sku)->get();

            $total_order_count = 0;

            foreach ($leadspros as $lead) {

                $order_count = Order::where('lead_id', $lead->id)->where('shipment_status', 'approved')->count();


                $total_order_count += $order_count;
            }

            if ($total_order_count > 0) {
                $highestCommissions[] = [
                    'highest_commission' => $highest_commission,
                    'amount' => $total_order_count * $highest_commission->comission
                ];
            }
        }




        $highest_commission = AffiliateProduct::whereIn('sku', $lead_skus)->orderByDesc('comission')
            ->limit(1)->first();

        if ($confirmed > 0) {

            $average_commission = $total_commission / $confirmed;
        }


        // dd($highestCommissions);

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

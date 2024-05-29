<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProduct;
use App\Models\Country;
use App\Models\Lead;
use App\Models\Order;
use App\Models\SharedProduct;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Foreach_;

class ReportController extends Controller
{
    public function index()
    {

        $orders = Order::count();
        $countries = Country::all();
        $leads = Lead::count();

        $under_process = 0;
        $confirmed = 0;
        $canceled = 0;
        $fulfilled = 0;
        $shipped = 0;
        $delivered = 0;
        $returned = 0;
        $confirmed_rate = 0;
        $delivered_rate = 0;

        $under_process = Order::where('shipment_status', 'pending')->count();
        $confirmed = Order::where('shipment_status', 'approved')->count();
        $canceled = Order::where('shipment_status', 'canceled')->count();
        $fulfilled = Order::where('shipment_status', 'fulfilled')->count();
        $shipped = Order::where('shipment_status', 'shipping')->count();
        $delivered = Order::where('shipment_status', 'delivered')->count();
        $returned = Order::where('shipment_status', 'returned')->count();

        if ($orders > 0) {
            $confirmed_rate = intval(($confirmed / $orders) * 100);
            $delivered_rate = intval(($delivered / $orders) * 100);
        }
        return view('admin.reports.index', compact('leads', 'under_process', 'confirmed', 'canceled', 'fulfilled', 'shipped', 'delivered', 'returned', 'countries', 'confirmed_rate', 'delivered_rate'));
    }

    public function filter_country($countryId)
    {
        $orders = Order::count();
        $countries = Country::all();
        $country = Country::findOrFail($countryId);
        $leads = Lead::where('warehouse', $country->name)->count();
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

        if ($orders > 0) {
            $confirmed_rate = intval(($confirmed / $orders) * 100);
            $delivered_rate = intval(($delivered / $orders) * 100);
        }

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
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();

                $under_process = Order::where('shipment_status', 'pending')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $confirmed = Order::where('shipment_status', 'approved')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $canceled = Order::where('shipment_status', 'canceled')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $fulfilled = Order::where('shipment_status', 'fulfilled')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $shipped = Order::where('shipment_status', 'shipping')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $delivered = Order::where('shipment_status', 'delivered')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $returned = Order::where('shipment_status', 'returned')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();
            }
        }

        // Calculate rates only if there are orders to avoid division by zero
        if ($orders > 0) {
            $confirmed_rate = intval(($confirmed / $orders) * 100);
            $delivered_rate = intval(($delivered / $orders) * 100);
        }

        return view('admin.reports.index', compact(
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

    public function affiliate_filter()
    {
        $leads = 0;
        $under_process = 0;
        $confirmed = 0;
        $highest_comissions = 0;
        $highest_comission = 0;
        $average_comission = 0;
        $delivered = 0;
        $confirmed_rate = 0;



        $leads = Lead::where('type', 'commission')->count();
        $lead_ids = Lead::where('type', 'commission')->pluck('id');


        $under_process = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'pending')->count();
        $confirmed = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'approved')->count();
        $delivered = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'delivered')->count();

        $lead_confirmed = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'approved')->pluck('lead_id');

        $lead_sku = Lead::whereIn('id', $lead_confirmed)->pluck('item_sku');
        $confirmed_rate = $leads > 0 ? intval(($confirmed / $leads) * 100) : 0;

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


        $average_commission = $total_commission / $confirmed;


        // dd($highestCommissions);

        return view('admin.reports.affiliate', compact(
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

        $affiliateSkus = Lead::where('type', 'commission')->distinct()->pluck('item_sku');

        $affiliateProducts = AffiliateProduct::whereIn('sku', $affiliateSkus)->get();


        $products = [];

        foreach ($affiliateProducts as $affiliateProduct) {

            $leadsCount = Lead::where('item_sku', $affiliateProduct->sku)->count();


            $leadIds = Lead::where('item_sku', $affiliateProduct->sku)->pluck('id');


            $confirmed = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'approved')->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->count();
            $fulfilled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'fulfilled')->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->count();
            $confirmed_rate = $leadsCount > 0 ? intval(($confirmed / $leadsCount) * 100) : 0;
            $delivered_rate = $leadsCount > 0 ? intval(($delivered / $leadsCount) * 100) : 0;

            $products[] = [
                'type' => 'affiliate',
                'product' => $affiliateProduct,
                'leads' => $leadsCount,
                'confirmed' => $confirmed,
                'cancelled' => $cancelled,
                'fulfilled' => $fulfilled,
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

            $confirmed = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'approved')->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->count();
            $fulfilled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'fulfilled')->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->count();
            $confirmed_rate = $leadsCount > 0 ? intval(($confirmed / $leadsCount) * 100) : 0;
            $delivered_rate = $leadsCount > 0 ? intval(($delivered / $leadsCount) * 100) : 0;


            $products[] = [
                'type' => 'shared',
                'product' => $sharedProduct,
                'leads' => $leadsCount,
                'confirmed' => $confirmed,
                'cancelled' => $cancelled,
                'fulfilled' => $fulfilled,
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






        return view('admin.reports.marketplace', compact('products'));
    }
}

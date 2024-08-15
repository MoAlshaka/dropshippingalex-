<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Lead;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\Revenue;
use Illuminate\Http\Request;
use App\Models\SharedProduct;
use App\Models\AffiliateProduct;
use App\Http\Controllers\Controller;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Analytics')->only(['index', 'filter_country', 'affiliate_filter', 'filter', 'marketplace_filter', 'markplace_filter_date', 'affiliate_filter_date']);
    }
    public function index()
    {

        $leads = Lead::where('type', 'regular')->count();
        $lead_ids = Lead::where('type', 'regular')->pluck('id');



        $orders = Order::whereIn('lead_id', $lead_ids)->count();
        $orders_ids = Order::whereIn('lead_id', $lead_ids)->pluck('id');
        $countries = Country::all();


        $under_process = 0;
        $confirmed = 0;
        $canceled = 0;
        $balance = 0;
        $shipped = 0;
        $delivered = 0;
        $returned = 0;
        $confirmed_rate = 0;
        $delivered_rate = 0;

        $under_process = Order::whereIn('lead_id', $orders_ids)->where('shipment_status', 'pending')->count();
        $confirmed = Lead::whereIn('id', $lead_ids)->where('status', 'confirmed')->count();
        $canceled = Order::whereIn('lead_id', $orders_ids)->where('shipment_status', 'canceled')->count();
        $revenue_confirmed  = Revenue::sum('revenue');
        $invoice_balance = Invoice::sum('revenue');
        $balance = $invoice_balance + $revenue_confirmed;
        $shipped = Order::whereIn('lead_id', $orders_ids)->where('shipment_status', 'shipping')->count();
        $delivered = Order::whereIn('lead_id', $orders_ids)->where('shipment_status', 'delivered')->count();
        $returned = Order::whereIn('lead_id', $orders_ids)->where('shipment_status', 'returned')->count();

        if ($orders > 0) {
            $confirmed_rate = intval(($confirmed / $orders) * 100);
            $delivered_rate = intval(($delivered / $orders) * 100);
        }
        $admins = Admin::where('roles_name', '!=', 'Owner')
            ->whereHas('sellers')
            ->get();

        $sellers = Seller::where('is_active', 1)->where('admin_id', auth()->user()->id)->get();

        $all_sellers = Seller::where('is_active', 1)->get();

        return view('admin.reports.index', compact('leads', 'under_process', 'confirmed', 'canceled', 'balance', 'shipped', 'delivered', 'returned', 'countries', 'confirmed_rate', 'delivered_rate', 'admins', 'sellers', 'all_sellers'));
    }

    public function filter_country($countryId)
    {
        $lead_ids = Lead::where('type', 'regular')->pluck('id');
        $orders_ids = Order::whereIn('lead_id', $lead_ids)->pluck('id');


        $orders = Order::whereIn('lead_id', $orders_ids)->count();
        $countries = Country::all();
        $country = Country::findOrFail($countryId);
        $leads = Lead::whereIn('id', $lead_ids)->where('warehouse', $country->name)->count();
        $under_process = Order::whereIn('lead_id', $orders_ids)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'pending')->count();
        $confirmed = Lead::whereIn('id', $lead_ids)->where('warehouse', $country->name)->where('status', 'confirmed')->count();
        $canceled = Order::whereIn('lead_id', $orders_ids)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'canceled')->count();
        $balance = Order::whereIn('lead_id', $orders_ids)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'balance')->count();
        $shipped = Order::whereIn('lead_id', $orders_ids)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'shipping')->count();
        $delivered = Order::whereIn('lead_id', $orders_ids)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'delivered')->count();
        $returned = Order::whereIn('lead_id', $orders_ids)->whereHas('lead', function ($query) use ($country) {
            $query->where('warehouse', $country->name);
        })->where('shipment_status', 'returned')->count();

        if ($orders > 0) {
            $confirmed_rate = intval(($confirmed / $orders) * 100);
            $delivered_rate = intval(($delivered / $orders) * 100);
        }
        $admins = Admin::where('roles_name', '!=', 'Owner')
            ->whereHas('sellers')
            ->get();

        $sellers = Seller::where('is_active', 1)->where('admin_id', auth()->user()->id)->get();

        $all_sellers = Seller::where('is_active', 1)->get();
        $country = Country::where('id', $countryId)->pluck('id')->first();
        return view('admin.reports.index', compact('leads', 'under_process', 'confirmed', 'canceled', 'balance', 'shipped', 'delivered', 'returned', 'countries', 'confirmed_rate', 'delivered_rate', 'admins', 'sellers', 'country', 'all_sellers'));
    }


    public function filter(Request $request, $id)
    {
        $orders = Order::count();
        $countries = Country::all();
        $country = 0;

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


        $seller_ids = [];
        if ($request->has('admin_id')) {
            foreach ($request->admin_id as $admin_id) {

                $manger = Admin::findOrFail($admin_id);
                foreach ($manger->sellers as $seller) {
                    array_push($seller_ids, $seller->id);
                }
            }
        }
        if ($request->has('seller_id')) {
            foreach ($request->seller_id as $seller_id) {
                array_push($seller_ids, $seller_id);
            }
        }
        $sellerIds = array_unique($seller_ids);

        $start_date = '';
        $end_date = '';
        if ($request->has('date') && $request->date != '') {
            $dates = explode(' - ', $request->date);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            }
        }
        if ($id == 0) {
            $leads = Lead::WhereBetween('created_at', [$start_date, $end_date] ?? [])
                ->WhereIn('seller_id', $sellerIds ?? [])
                ->count();


            $under_process = Order::where(function ($query) use ($start_date, $end_date, $sellerIds) {
                $query->where('shipment_status', 'pending')
                    ->where(function ($query) use ($start_date, $end_date, $sellerIds) {
                        $query->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                            ->WhereIn('seller_id', $sellerIds ?? []);
                    });
            })->count();

            $confirmed = Lead::where(function ($query) use ($start_date, $end_date, $sellerIds) {
                $query->where('status', 'confirmed')
                    ->where(function ($query) use ($start_date, $end_date, $sellerIds) {
                        $query->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                            ->WhereIn('seller_id', $sellerIds ?? []);
                    });
            })->count();

            $revenue_confirmed  = Revenue::WhereIn('seller_id', $sellerIds ?? [])->sum('revenue');
            $invoice_balance = Invoice::WhereIn('seller_id', $sellerIds ?? [])->sum('revenue');
            $balance = $invoice_balance + $revenue_confirmed;

            $canceled = Order::where(function ($query) use ($start_date, $end_date, $sellerIds) {
                $query->where('shipment_status', 'canceled')
                    ->where(function ($query) use ($start_date, $end_date, $sellerIds) {
                        $query->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                            ->WhereIn('seller_id', $sellerIds ?? []);
                    });
            })->count();


            $delivered = Order::where(function ($query) use ($start_date, $end_date, $sellerIds) {
                $query->where('shipment_status', 'delivered')
                    ->where(function ($query) use ($start_date, $end_date, $sellerIds) {
                        $query->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                            ->WhereIn('seller_id', $sellerIds ?? []);
                    });
            })->count();

            $returned = Order::where(function ($query) use ($start_date, $end_date, $sellerIds) {
                $query->where('shipment_status', 'returned')
                    ->where(function ($query) use ($start_date, $end_date, $sellerIds) {
                        $query->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                            ->WhereIn('seller_id', $sellerIds ?? []);
                    });
            })->count();
        } else {
            $country = Country::findOrFail($id);
            $leads = Lead::WhereBetween('created_at', [$start_date, $end_date] ?? [])
                ->WhereIn('seller_id', $sellerIds ?? [])
                ->where('warehouse', $country->name)
                ->count();
            $leadsId = Lead::WhereBetween('created_at', [$start_date, $end_date] ?? [])
                ->WhereIn('seller_id', $sellerIds ?? [])
                ->where('warehouse', $country->name)
                ->pluck('id')
                ->unique();


            $under_process = Order::where(function ($query) use ($start_date, $end_date, $sellerIds, $leadsId) {
                $query->where('shipment_status', 'pending')
                    ->where(function ($query) use ($start_date, $end_date, $sellerIds, $leadsId) {
                        $query->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                            ->WhereIn('seller_id', $sellerIds ?? [])
                            ->whereIn('lead_id', $leadsId ?? []);
                    });
            })->count();

            $confirmed = Lead::where(function ($query) use ($start_date, $end_date, $sellerIds, $leadsId) {
                $query->where('status', 'confirmed')
                    ->where(function ($query) use ($start_date, $end_date, $sellerIds, $leadsId) {
                        $query->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                            ->WhereIn('seller_id', $sellerIds ?? [])
                            ->whereIn('id', $leadsId ?? []);
                    });
            })->count();

            $canceled = Order::where('shipment_status', 'canceled')
                ->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                ->WhereIn('seller_id', $sellerIds ?? [])

                ->count();

            $canceled = Order::where(function ($query) use ($start_date, $end_date, $sellerIds, $leadsId) {
                $query->where('shipment_status', 'canceled')
                    ->where(function ($query) use ($start_date, $end_date, $sellerIds, $leadsId) {
                        $query->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                            ->WhereIn('seller_id', $sellerIds ?? [])
                            ->whereIn('lead_id', $leadsId ?? []);
                    });
            })->count();

            $balance = Order::where(function ($query) use ($start_date, $end_date,  $sellerIds, $leadsId) {
                $query->where('shipment_status', 'balance')
                    ->where(function ($query) use ($start_date, $end_date, $sellerIds, $leadsId) {
                        $query->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                            ->WhereIn('seller_id', $sellerIds ?? [])
                            ->whereIn('lead_id', $leadsId ?? []);
                    });
            })->count();
            $delivered = Order::where(function ($query) use ($start_date, $end_date, $sellerIds, $leadsId) {
                $query->where('shipment_status', 'delivered')
                    ->where(function ($query) use ($start_date, $end_date, $sellerIds, $leadsId) {
                        $query->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                            ->WhereIn('seller_id', $sellerIds ?? [])
                            ->whereIn('lead_id', $leadsId ?? []);
                    });
            })->count();

            $returned = Order::where(function ($query) use ($start_date, $end_date, $sellerIds, $leadsId) {
                $query->where('shipment_status', 'returned')
                    ->where(function ($query) use ($start_date, $end_date, $sellerIds, $leadsId) {
                        $query->WhereBetween('created_at', [$start_date, $end_date] ?? [])
                            ->WhereIn('seller_id', $sellerIds ?? [])
                            ->whereIn('lead_id', $leadsId ?? []);
                    });
            })->count();

            $country = Country::where('id', $id)->pluck('id')->first();
        }
        // Calculate rates only if there are orders to avoid division by zero
        if ($orders > 0) {
            $confirmed_rate = intval(($confirmed / $orders) * 100);
            $delivered_rate = intval(($delivered / $orders) * 100);
        }
        $admins = Admin::where('roles_name', '!=', 'Owner')
            ->whereHas('sellers')
            ->get();

        $sellers = Seller::where('is_active', 1)->where('admin_id', auth()->user()->id)->get();

        $all_sellers = Seller::where('is_active', 1)->get();
        return view('admin.reports.index', compact(
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
            'delivered_rate',
            'admins',
            'sellers',
            'country',
            'all_sellers',
        ));
    }

    public function affiliate_filter()
    {
        $leads = 0;
        $under_process = 0;
        $confirmed = 0;
        $highest_commissions = 0;
        $highest_commission = 0;
        $average_commission = 0;
        $delivered = 0;
        $confirmed_rate = 0;
        $highestCommissions = [];


        $leads = Lead::where('type', 'commission')->count();
        $lead_ids = Lead::where('type', 'commission')->pluck('id');


        $under_process = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'pending')->count();
        $confirmed = Lead::whereIn('id', $lead_ids)->where('status', 'confirmed')->count();

        $delivered = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'delivered')->count();

        $lead_confirmed = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'delivered')->pluck('lead_id');

        $lead_sku = Lead::whereIn('id', $lead_confirmed)->pluck('item_sku');
        if ($leads > 0) {
            $confirmed_rate = $leads > 0 ? intval(($confirmed / $leads) * 100) : 0;
        }


        // Retrieve confirmed leads and their SKUs
        $lead_confirmedId = Lead::whereIn('id', $lead_ids)->where('status', 'confirmed')->pluck('id');
        $lead_confirmed = Lead::whereIn('id', $lead_ids)->where('status', 'confirmed')->get();


        $lead_sku = Lead::whereIn('id', $lead_confirmedId)->pluck('item_sku')->unique();

        // Retrieve affiliate product commissions


        // Calculate total commission
        // $orders = Order::whereIn('lead_id', $lead_confirmed)->where('shipment_status', 'delivered')->get();
        $total_commission = 0;
        $total_quantity = 0;
        if ($lead_confirmed) {
            foreach ($lead_confirmed as $lead) {
                $quantity = Lead::where('id', $lead->id)->pluck('quantity')->first();

                $total_commission += AffiliateProduct::where('sku', $lead->item_sku)->pluck('commission')->first()  * $quantity;
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
        if ($confirmed > 0 && $total_quantity > 0) {
            $average_commission = $total_commission / $total_quantity;
            $average_commission = number_format($average_commission, 2);
        }



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


            $confirmed = Lead::whereIn('id', $leadIds)->where('status', 'confirmed')->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->count();
            $balance = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'balance')->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->count();
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

            $confirmed = Lead::whereIn('id', $leadIds)->where('status', 'confirmed')->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->count();
            $balance = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'balance')->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->count();
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






        return view('admin.reports.marketplace', compact('products'));
    }

    public function markplace_filter_date(Request $request)
    {
        $request->validate([
            'date' => 'required'
        ]);
        $start_date = '';
        $end_date = '';
        if ($request->has('date') && $request->date != '') {
            $dates = explode(' - ', $request->date);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            }
        }

        $affiliateSkus = Lead::where('type', 'commission')->WhereBetween('created_at', [$start_date, $end_date] ?? [])->distinct()->pluck('item_sku');

        $affiliateProducts = AffiliateProduct::whereIn('sku', $affiliateSkus)->get();


        $products = [];


        foreach ($affiliateProducts as $affiliateProduct) {

            $leadsCount = Lead::where('item_sku', $affiliateProduct->sku)->count();


            $leadIds = Lead::where('item_sku', $affiliateProduct->sku)->pluck('id');

            $confirmed = Lead::whereIn('id', $leadIds)->where('status', 'confirmed')->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->count();
            $balance = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'balance')->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->count();
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


        $sharedSkus = Lead::where('type', 'regular')->whereBetween('created_at', [$start_date, $end_date] ?? [])->distinct()->pluck('item_sku');


        $sharedProducts = SharedProduct::whereIn('sku', $sharedSkus)->get();

        foreach ($sharedProducts as $sharedProduct) {

            $leadsCount = Lead::where('item_sku', $sharedProduct->sku)->count();


            $leadIds = Lead::where('item_sku', $sharedProduct->sku)->pluck('id');

            $confirmed = Lead::whereIn('lead_id', $leadIds)->where('status', 'confirmed')->count();
            $cancelled = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'canceled')->count();
            $balance = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'balance')->count();
            $shipped = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'shipping')->count();
            $delivered = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'delivered')->count();
            $returned = Order::whereIn('lead_id', $leadIds)->where('shipment_status', 'returned')->count();
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






        return view('admin.reports.marketplace', compact('products'));
    }

    public function affiliate_filter_date(Request $request)
    {
        $request->validate([
            'date' => 'required'
        ]);
        $leads = 0;
        $under_process = 0;
        $confirmed = 0;
        $highest_commissions = 0;
        $highest_commission = 0;
        $average_commission = 0;
        $delivered = 0;
        $confirmed_rate = 0;
        $highestCommissions = [];


        $lead_ids = Lead::where('type', 'commission')->pluck('id');
        $start_date = '';
        $end_date = '';
        if ($request->has('date') && $request->date != '') {
            $dates = explode(' - ', $request->date);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            }
        }
        $leads = Lead::where('type', 'commission')->whereBetween('order_date', [$start_date, $end_date] ?? [])->count();

        $under_process = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'pending')->whereBetween('created_at', [$start_date, $end_date] ?? [])->count();
        $confirmed = Lead::whereIn('id', $lead_ids)->where('status', 'confirmed')->whereBetween('created_at', [$start_date, $end_date] ?? [])->count();
        $delivered = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'delivered')->whereBetween('created_at', [$start_date, $end_date] ?? [])->count();

        $lead_confirmed = Order::whereIn('lead_id', $lead_ids)->where('shipment_status', 'delivered')->whereBetween('created_at', [$start_date, $end_date] ?? [])->pluck('lead_id');


        $lead_sku = Lead::whereIn('id', $lead_confirmed)->pluck('item_sku');
        if ($leads > 0) {

            $confirmed_rate = $leads > 0 ? intval(($confirmed / $leads) * 100) : 0;
        }


        // Retrieve confirmed leads and their SKUs
        $lead_confirmedId = Lead::whereIn('id', $lead_ids)->where('status', 'confirmed')->pluck('id');
        $lead_confirmed = Lead::whereIn('id', $lead_ids)->where('status', 'confirmed')->get();

        $lead_sku = Lead::whereIn('id', $lead_confirmedId)->pluck('item_sku')->unique();

        // Retrieve affiliate product commissions


        // Calculate total commission
        // $orders = Order::whereIn('lead_id', $lead_confirmed)->where('shipment_status', 'delivered')->get();
        $total_commission = 0;
        $total_quantity = 0;
        if ($lead_confirmed) {
            foreach ($lead_confirmed as $lead) {
                $quantity = Lead::where('id', $lead->id)->pluck('quantity')->first();

                $total_commission += AffiliateProduct::where('sku', $lead->item_sku)->pluck('commission')->first()  * $quantity;
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
            $average_commission = number_format($average_commission, 2);
        }





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
}

<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\SharedProduct;
use App\Models\AffiliateProduct;
use App\Http\Controllers\Controller;

class LeadController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:All Leads')->only(['index']);
        $this->middleware('permission:Show Lead')->only(['show']);
        $this->middleware('permission:Edit Lead')->only(['edit', 'update']);
        $this->middleware('permission:Delete Lead')->only(['destroy']);
    }
    public function index()
    {
        $countries = Country::all();
        $status = Lead::distinct()->pluck('status')->unique();
        $types = Lead::distinct()->pluck('type')->unique();
        $leads = Lead::orderBy('id', 'DESC')->paginate(COUNT);
        return view('admin.leads.index', compact('leads', 'countries', 'status', 'types'));
    }

    public function edit($id)
    {
        $lead = Lead::findorfail($id);
        return view('admin.leads.edit', compact('lead'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'notes' => 'nullable|string|max:65000'
        ]);
        $lead = Lead::findorfail($id);
        $flag = $lead->update([
            'status' => $request->status
        ]);
        if ($flag && $lead->status == 'confirmed') {

            Order::create([
                'lead_id' => $lead->id,
                'quantity' => $lead->quantity,
                'seller_id' => $lead->seller_id,
            ]);
        }
        return redirect()->route('admin.leads.index')->with(['Update' => 'Lead status updated successfully']);
    }

    public function delete($id)
    {
        $lead = Lead::findorfail($id);
        if ($lead->status == 'pending') {
            $lead->delete();
            return redirect()->route('admin.leads.index')->with(['Delete' => 'Lead deleted successfully.']);
        }
        return redirect()->route('admin.leads.index')->with(['Warning' => 'Lead cannot be deleted.']);
    }

    public function show($id)
    {
        $lead = Lead::findorfail($id);
        $sharedproduct = SharedProduct::where('sku', $lead->item_sku)->first();
        $affiliateproduct = AffiliateProduct::where('sku', $lead->item_sku)->first();
        $country = Country::where('name', $lead->warehouse)->first();
        return view('admin.leads.show', compact('lead', 'country', 'affiliateproduct', 'sharedproduct'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'ref' => 'required|max:50'
        ]);
        $countries = Country::all();
        $status = Lead::distinct()->pluck('status')->unique();
        $types = Lead::distinct()->pluck('type')->unique();
        $leads = Lead::where('store_reference', $request->ref)->orderBy('id', 'DESC')->paginate(COUNT);
        return view('admin.leads.index', compact('leads', 'countries', 'status', 'types'));
        // return redirect()->route('admin.leads.index', compact('leads', 'countries', 'status', 'types'));
    }

    public function filter(Request $request)
    {

        $query = Lead::query();
        $start_date = '';
        $end_date = '';
        if ($request->has('created_at') && $request->created_at != '') {
            $dates = explode(' - ', $request->created_at);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            }
        }

        // $leads = Lead::WhereIn('warehouse', $request->warehouse ?? [])
        //     ->WhereIn('customer_country', $request->country ?? [])
        //     ->WhereIn('status', $request->status ?? [])
        //     ->WhereIn('type', $request->type ?? [])
        //     ->orWhereBetween('order_date', [$start_date, $end_date] ?? [])
        //     ->orderBy('id', 'DESC')->paginate(COUNT);


        if ($request->has('created_at') && $request->created_at != '') {
            $query->whereBetween('order_date', [$start_date, $end_date] ?? []);
        }
        if ($request->has('warehouse') && $request->warehouse != '') {
            $query->WhereIn('warehouse', $request->warehouse ?? []);
        }

        if ($request->has('country') && $request->country != '') {
            $query->WhereIn('customer_country', $request->country ?? []);
        }
        if ($request->has('status') && $request->status != '') {
            $query->WhereIn('status', $request->status ?? []);
        }
        if ($request->has('type') && $request->type != '') {
            $query->WhereIn('type', $request->type ?? []);
        }

        $leads = $query->orderBy('id', 'DESC')->paginate(COUNT); // Replace 10 with your desired number of items per page
        $countries = Country::all();
        $status = Lead::distinct()->pluck('status')->unique();
        $types = Lead::distinct()->pluck('type')->unique();
        // return redirect()->route('admin.leads.index', compact('leads', 'countries', 'status', 'types'));
        return view('admin.leads.index', compact('leads', 'countries', 'status', 'types'));
    }
}

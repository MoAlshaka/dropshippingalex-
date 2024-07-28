<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProduct;
use App\Models\Country;
use App\Models\Lead;
use App\Models\Order;
use App\Models\SharedProduct;
use Illuminate\Http\Request;

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
        $status = Lead::distinct()->pluck('status');
        $types = Lead::distinct()->pluck('type');
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
            'status' => 'required'
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
        $leads = Lead::where('store_reference', $request->ref)->orderBy('id', 'DESC')->paginate(COUNT);
        return view('admin.leads.index', compact('leads'));
    }

    public function filter(Request $request)
    {

        $query = Lead::query();

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
            $query->orWhereIn('warehouse', $request->warehouse);
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

        $leads = $query->orderBy('id', 'DESC')->paginate(COUNT); // Replace 10 with your desired number of items per page
        $countries = Country::all();
        $status = Lead::distinct()->pluck('status');
        $types = Lead::distinct()->pluck('type');
        return view('admin.leads.index', compact('leads', 'countries', 'status', 'types'));
    }
}

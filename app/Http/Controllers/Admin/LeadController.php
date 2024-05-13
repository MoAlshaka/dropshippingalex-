<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProduct;
use App\Models\Country;
use App\Models\Lead;
use App\Models\SharedProduct;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::orderBy('id', 'DESC')->paginate(COUNT);
        return view('admin.leads.index', compact('leads'));
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
        $lead->update([
            'status' => $request->status
        ]);
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
        $sharedproduct=SharedProduct::where('sku',$lead->item_sku)->first();
        $affiliateproduct=AffiliateProduct::where('sku',$lead->item_sku)->first();
        $country= Country::where('name' ,$lead->warehouse )->first();
        return view('admin.leads.show', compact('lead' , 'country' , 'affiliateproduct' , 'sharedproduct'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'ref' => 'required|max:50'
        ]);
        $leads=Lead::where('store_reference',$request->ref)->orderBy('id', 'DESC')->paginate(COUNT);
        return view('admin.leads.index', compact('leads'));
    }
    public function filter(Request $request)
    {

        $query = Lead::query();

        if ($request->has('order_date') && $request->date != '') {
            $query->whereBetween('order_date', [now(), $request->date]);
        }

        if ($request->has('warehouse') && $request->warehouse != '') {
            $query->orWhere('warehouse',  $request->warehouse );
        }

        if ($request->has('country') && $request->country != '') {
            $query->orWhere('country', $request->country);
        }
        if ($request->has('status') && $request->status != '') {
            $query->orWhere('status', $request->status);
        }
        if ($request->has('type') && $request->type != '') {
            $query->orWhere('type', $request->type);
        }

        $leads = $query->orderBy('id', 'DESC')->paginate(COUNT);// Replace 10 with your desired number of items per page

        return view('admin.leads.index', compact('leads'));
    }

}

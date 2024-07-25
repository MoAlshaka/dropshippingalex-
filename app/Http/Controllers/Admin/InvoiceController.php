<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::orderBy('id', 'DESC')->paginate(COUNT);
        $status = Invoice::pluck('status')->unique();
        $sellers = Seller::all();
        return view('admin.invoices.index', compact('invoices', 'status', 'sellers'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = Invoice::findorfail($id);
        return view('admin.invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required'
        ]);
        $invoice = Invoice::findorfail($id);
        $flag = $invoice->update([
            'status' => $request->status,
            'updated_at' => date("Y-m-d"),
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('admin.invoices.index')->with(['Update' => 'invoice status updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function filter(Request $request)
    {
        if ($request->has('date') && $request->date != '') {
            $dates = explode(' - ', $request->date);

            // Ensure both start and end dates are available
            if (count($dates) === 2) {
                $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
            }
        }

        $invoices = Invoice::where('seller_id', auth()->guard('seller')->id())
            ->orWhereBetween('created_at', [$start_date, $end_date])
            ->orWhere('status', $request->status)
            ->orWhere('seller_id', $request->seller_id)
            ->orderBy('id', 'DESC')->paginate(COUNT);
        $status = Invoice::pluck('status')->unique();
        $sellers = Seller::all();
        return redirect()->route('seller.invoices.index', compact('invoices', 'status', 'sellers'));
    }
}

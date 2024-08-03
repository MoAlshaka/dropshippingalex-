<?php

namespace App\Http\Controllers\Seller;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = Invoice::pluck('status')->unique();
        $invoices = Invoice::where('seller_id', auth()->guard('seller')->id())->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);

        return view('seller.invoices.index', compact('invoices', 'status'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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

        $invoices = Invoice::where('seller_id', auth()->guard('seller')->id())
            ->orWhereBetween('created_at', [$start_date, $end_date])
            ->WhereIn('status', $request->status ?? [])
            ->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        $status = Invoice::pluck('status')->unique();
        return redirect()->route('seller.invoices.index', compact('invoices', 'status'));
    }
}

<?php

namespace App\Http\Controllers\Seller;

use App\Models\Revenue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Seller;
use Carbon\Carbon;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $revenue_confirmed  = Revenue::where('seller_id', auth()->guard('seller')->id())->sum('revenue');
        $invoice_balance = Invoice::where('seller_id', auth()->guard('seller')->id())->sum('revenue');
        $balance = $invoice_balance + $revenue_confirmed;
        return view('seller.wallet.index', compact('balance', 'revenue_confirmed'));
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

    // public function filter(Request $request)
    // {

    //     if ($request->has('date') && $request->date != '') {
    //         $dates = explode(' - ', $request->date);
    //         if (count($dates) === 2) {
    //             $start_date = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
    //             $end_date = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();
    //         }
    //     }
    //     $balance = Revenue::where('seller_id', auth()->guard('seller')->id())->whereBetween('date', [$start_date, $end_date])->sum('revenue');
    //     $revenue_confirmed = Revenue::where(['seller_id' => auth()->guard('seller')->id(), 'is_confirmed' => 1])->whereBetween('date', [$start_date, $end_date])->sum('revenue');

    //     return redirect()->route('seller.wallet.filter', compact('balance', 'revenue_confirmed'));
    // }
}

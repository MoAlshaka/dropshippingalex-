<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::all();
        return view('admin.payments.index',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.payments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|max:100',

        ]);
        $payment = $request->payment_method;
        if (Payment::where('payment_method', $payment)->exists()) {
            return redirect()->route('payments.index')->with(['Warning' => 'This Payment already exists']);
        }
        Payment::create([
            'payment_method' => $request->payment_method,
        ]);
        return redirect()->route('payments.index')->with(['Add' => 'Add successfully']);

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
        $payment = Payment::findorfail($id);
        return view('admin.payments.edit')->with(['payment' => $payment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'payment_method' => 'required|max:100',

        ]);
        $payment = Payment::findorfail($id);
        $payment->update([
            'payment_method' => $request->payment_method,
        ]);
        return redirect()->route('payments.index')->with(['Update' => 'Update successfully']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Payment::destroy($id);
            return redirect()->route('payments.index')->with(['Delete' => 'Delete successfully']);
        } catch (\Throwable $th) {
            return redirect()->route('payments.index')->with(['Warning' => 'لا يمكن حذف هذا الحقل لانه مرتيط بحقول أخرى']);
        }
    }
}

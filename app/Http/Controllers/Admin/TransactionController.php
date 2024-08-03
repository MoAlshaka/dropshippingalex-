<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Seller;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\CreateTransaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::orderBy('id', 'DESC')->paginate(COUNT);
        $sellers = Seller::where('is_active', 1)->get();

        return view('admin.transactions.index', compact('transactions', 'sellers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'payment_method' => 'required|exists:sellers,payment_method',
            'account' => 'required|exists:sellers,account',
            'amount' => 'required|numeric',
            'status' => 'required|max:50',
        ]);

        $user = Seller::where('id', $request->seller_id)->first();
        $transaction = Transaction::create([
            'seller_id' => $request->seller_id,
            'payment_method' => $request->payment_method,
            'account' => $request->account,
            'amount' => $request->amount,
            'status' => $request->status,
            'created_at' => date('Y-m-d H:i:s'),
            'admin_id' => auth()->guard('admin')->user()->id,
        ]);
        if ($transaction) {
            $user->notify(new CreateTransaction($transaction->amount, $transaction->status, $transaction->payment_method, $transaction->account_number));
            Invoice::create([
                'seller_id' => $request->seller_id,
                'revenue' => $request->amount,
                'date' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'status' => $request->status,
            ]);
        }
        return redirect()->route('transactions.index')->with(['Add' => 'Add Transaction Successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sellers = Seller::all();
        return view('admin.transactions.create', compact('sellers'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::findorfail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sellers = Seller::all();
        $transaction = Transaction::findorfail($id);
        return view('admin.transactions.edit', compact('sellers', 'transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'payment_method' => 'required|exists:sellers,payment_method',
            'account' => 'required|exists:sellers,account',
            'amount' => 'required|numeric',
            'status' => 'required|max:50',
        ]);
        $transaction = Transaction::findorfail($id);
        $transaction->update([
            'seller_id' => $request->seller_id,
            'payment_method' => $request->payment_method,
            'account' => $request->account,
            'amount' => $request->amount,
            'status' => $request->status,
            'admin_id' => auth()->guard('admin')->user()->id,
        ]);

        return redirect()->route('transactions.index')->with(['Update' => 'Update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findorfail($id);
        $transaction->delete();
        return redirect()->route('transactions.index')->with(['Delete' => 'Delete successfully']);
    }

    public function get_seller_info($id)
    {

        $result = Seller::where('id', $id)->first();
        $data = [];
        $data['payment_method'] = $result->payment_method;
        $data['account_number'] = $result->account;


        return response()->json($data);
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
        $transactions = Transaction::WhereIn('seller_id', $request->seller_id ?? [])
            ->WhereIn('status', $request->status ?? [])
            ->orWhereBetween('created_at', [$start_date, $end_date] ?? [])
            ->orderBy('id', 'DESC')->paginate(COUNT);
        $sellers = Seller::where('is_active', 1)->get();

        return view('admin.transactions.index', compact('transactions', 'sellers'));
    }
}

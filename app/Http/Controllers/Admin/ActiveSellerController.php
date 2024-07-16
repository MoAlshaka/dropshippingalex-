<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Seller;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ActiveSellerController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Show Seller')->only(['show']);
        $this->middleware('permission:Delete Seller')->only(['delete']);
        $this->middleware('permission:Manage Seller')->only(['active']);
    }

    public function index()
    {
        $sellers = Seller::orderBy('id', 'desc')->get();
        return view('admin.sellers.index', compact('sellers'));
    }
    public function show($id)
    {
        $seller = Seller::findorfail($id);
        $admins = Admin::where('roles_name', '!=', 'Owner')->get();
        return view('admin.sellers.show', compact('seller', 'admins'));
    }
    public function active(Request $request, $id)
    {
        $seller = Seller::findorfail($id);
        if ($seller->is_active == 1) {
            $seller->update(['is_active' => 0]);
            return redirect()->back()->with(['Update' => 'Deactivate user successfully']);
        } else {
            $seller->update(['is_active' => 1]);
            Mail::to($seller->email)->send(new VerifyMail($seller->name));
            return redirect()->back()->with(['Update' => 'Active user successfully']);
        }
    }

    public function delete($id)
    {
        $seller = Seller::findorfail($id);
        $seller->delete();
        return redirect()->route('admin.sellers.index')->with(['Delete' => 'delete successfully']);
    }

    public function add_manager(Request $request, $id)
    {
        $request->validate([
            'admin_id' => 'required',
        ]);
        $seller = Seller::findorfail($id);
        $seller->update([
            'admin_id' => $request->admin_id
        ]);
        return redirect()->back()->with(['Add' => 'Add Account Manager successfully']);
    }
}

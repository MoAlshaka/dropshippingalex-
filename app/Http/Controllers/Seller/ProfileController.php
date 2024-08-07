<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function index()
    {
        $seller = auth()->guard('seller')->user();


        return view('seller.auth.profile', compact('seller'));
    }

    public function update_profile(Request $request, $id)
    {

        $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'phone' => 'required|max:50',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',

        ]);

        $seller = Seller::findorfail($id);
        $exists = Seller::where('email', $request->email)->where('id', '!=', $id)->first();
        if ($exists) {
            return redirect()->back()->with(['Delete' => 'Email already exists']);
        }
        $old_image = $seller->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/sellers/images'), $image_name);
            if ($seller->image && file_exists(public_path('sellers/images/' . $seller->image))) {
                unlink(public_path('assets/sellers/images/' . $seller->image));
            }
        }

        $seller->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => str_replace(' ', '', $request->phone),
            'address' => $request->address ?? null,
            'image' => $image_name ?? $old_image,

        ]);
        return redirect()->route('seller.profile')->with(['Update' => 'update Profile successfully']);
    }

    public function edit_password()
    {
        $seller = auth()->guard('seller')->user();
        return view('seller.auth.password', compact('seller'));
    }

    public function change_password(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'old_password' => 'required|max:50',
            'new_password' => 'required|max:50',
            'confirm_password' => 'required|max:50|same:new_password',
        ]);

        $seller = Seller::findOrFail($id);

        if (!Hash::check($request->old_password, $seller->password)) {
            return redirect()->back()->withInput()->withErrors(['old_password' => 'The old password is incorrect']);
        }

        $seller->update([
            'password' => bcrypt($request->new_password),
        ]);
        return redirect()->route('seller.edit.password')->with('Add', 'Password changed successfully');
    }

    public function payment_details(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|max:50',

        ]);
        $seller = Seller::findOrFail($id);
        if ($request->payment_method === 'vodafone') {
            $request->validate([
                'account' => 'required|regex:/^[0-9]{1,11}$/', // Ensure account is 1 to 11 digits long
            ]);

            $seller->update([
                'payment_method' => $request->payment_method,
                'account' => $request->account,
            ]);
        } else {
            $request->validate([
                'account' => 'required|email|max:50',

            ]);
            $seller->update([
                'payment_method' => $request->payment_method,
                'account' => $request->account,

            ]);
        }
        return redirect()->route('seller.profile')->with(['Update' => 'update Profile successfully']);
    }
}

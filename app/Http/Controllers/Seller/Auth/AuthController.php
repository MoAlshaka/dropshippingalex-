<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function get_seller_register()
    {
        return view('seller.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|unique:sellers|max:50',
            'password' => 'required|min:8|max:50',
            'confirm_password' => 'required|same:password|max:50|min:8',
            // 'address' => 'required|max:250',
            'phone' => 'required|max:14',
            // 'about_us' => 'required|max:800',
            'national_id' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);
        $exists = Seller::where('email', $request->email)->first();
        if ($exists) {
            return redirect()->back()->with(['Delete' => 'Email already exists']);
        }
        $national_id = $request->file('national_id');
        $national_id_name = time() . '.' . $national_id->getClientOriginalExtension();
        $national_id->move(public_path('assets/sellers/images/national_id'), $national_id_name);

        $seller = Seller::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => str_replace(' ', '', $request->phone),
            // 'address' => $request->address,
            'national_id' => $national_id_name,
            'about_us' => $request->about_us ?? null,
        ]);

        auth()->guard('seller')->login($seller);

        return redirect()->route('seller.deactivate');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|max:50',
            'password' => 'required|max:50',
        ]);
        // Attempt to authenticate the seller
        if (auth()->guard('seller')->attempt(['email' => $request->email, 'password' => $request->password])) {

            $seller = auth()->guard('seller')->user();
            // Check if the seller is active
            if ($seller->is_active == 0) {
                return redirect()->route('seller.deactivate');
            } else {
                // If active, log in the seller and redirect to the dashboard
                auth()->guard('seller')->login($seller);
                return redirect()->route('seller.dashboard');
            }
        } else {
            // If authentication fails, redirect back with an error message
            return redirect()->back()->with([
                'error' => 'The email or password is incorrect.'
            ]);
        }
    }

    public function get_seller_login()
    {
        return view('seller.auth.login');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('get.seller.login');
    }

    public function deactivate()
    {
        return view('seller.auth.deactivate');
    }

    public function mail_reset_password(Request $request)
    {

        $request->validate([
            'email' => 'required|email|max:50',
        ]);

        $seller = Seller::where('email', $request->email)->first();
        if (!$seller) {
            return redirect()->back()->with(['Delete' => 'Email not found']);
        }

        Mail::to($request->email)->send(new ResetPasswordMail($request->email));
        return redirect()->back()->with(['Add' => 'Password reset link sent to your email, check your email']);
    }

    public function reset_password_page($email)
    {
        return view('seller.auth.resetpassword', compact('email'));
    }

    public function reset_password_store(Request $request, $email)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'new_password' => 'required|max:50',
            'confirm_password' => 'required|max:50|same:new_password',

        ]);
        if ($request->email != $email) {
            return redirect()->back()->with('Delete', 'Your Email is defferent from the email that we sent to you');
        }
        $seller = Seller::where('email', $request->email)->first();
        if (!$seller) {
            return redirect()->back()->with(['Delete' => 'Email not found']);
        }
        $seller->update([
            'password' => bcrypt($request->new_password),
        ]);
        return redirect()->route('seller.login')->with('Add', 'Password reset successfully');
    }
}

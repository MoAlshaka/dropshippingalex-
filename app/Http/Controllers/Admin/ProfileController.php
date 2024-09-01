<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = auth()->guard('admin')->user();


        return view('admin.auth.profile', compact('admin'));
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

    public function update_profile(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|max:50',
            'username' => 'required|max:50',
            'phone' => 'required|min:11|max:12',
            'email' => 'nullable|email|max:50',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',

        ]);
        $admin = Admin::findorfail($id);
        $exists_username = Admin::where(['username' => $request->username])->where('id', '!=', $id)->first();
        if ($exists_username) {
            return redirect()->back()->with(['Delete' => 'Username already exists']);
        }
        $exists_phone = Admin::where(['phone' => $request->phone])->where('id', '!=', $id)->first();
        if ($exists_phone) {
            return redirect()->back()->with(['Delete' => 'phone already exists']);
        }
        if ($request->email) {

            $exists = Admin::where(['email' => $request->email])->where('id', '!=', $id)->first();
            if ($exists) {
                return redirect()->back()->with(['Delete' => 'Email already exists']);
            }
        }
        $old_image = $admin->image;


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/admins/images'), $image_name);
            if ($admin->image && file_exists(public_path('admins/images/' . $admin->image))) {
                unlink(public_path('assets/admins/images/' . $admin->image));
            }
        }


        $admin->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email ?? null,
            'phone' => $request->phone,
            'image' => $image_name ?? $old_image,
        ]);
        return redirect()->route('admin.profile')->with(['Update' => 'update Profile successfully']);
    }

    public function edit_password()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.auth.password', compact('admin'));
    }


    public function change_password(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'old_password' => 'required|max:50',
            'new_password' => 'required|max:50',
            'confirm_password' => 'required|max:50|same:new_password',
        ]);

        $admin = Admin::findOrFail($id);

        if (!Hash::check($request->old_password, $admin->password)) {
            return redirect()->back()->withInput()->withErrors(['old_password' => 'The old password is incorrect']);
        }

        $admin->update([
            'password' => bcrypt($request->new_password),
        ]);
        return redirect()->route('admin.edit.password')->with('Add', 'Password changed successfully');
    }
}

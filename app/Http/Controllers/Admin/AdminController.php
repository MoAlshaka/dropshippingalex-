<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:All Admin', ['only' => ['index']]);
        $this->middleware('permission:Add Admin', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit Admin', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Admin', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Admin::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Owner');
        })->get();

        return view('admin.admins.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('admin.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:100',
            'username' => 'required|unique:admins',
            'password' => 'required|min:4|max:50|confirmed',
            'roles_name' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        // dd($input);

        $user = Admin::create($input);

        // Get the team_manager_id based on team_id
        $user->assignRole($request->input('roles_name'));
        $message = ' User created successfully.';
        $notification = array(
            'message' => $message,
            'alert-type' => 'success'
        );

        return redirect()->route('admins.create')->with($notification);
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
    public function edit($id)
    {
        $user = Admin::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.admins.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'nullable|min:3|max:100',
            'username' => 'nullable|unique:users,username,' . $id,
            'password' => 'nullable|min:8|max:50',
            'status' => 'nullable',
            'roles_name' => 'required',
        ]);

        $user = Admin::findOrFail($id);

        // Update user information
        $input = $request->except(['_token', '_method', 'password_confirmation']);

        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        } else {
            // If no new password is provided, keep the existing password
            $input['password'] = $user->password;
        }

        $user->update($input);

        // Remove existing roles and assign new roles
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles_name'));

        $message = ' User updated successfully.';
        $notification = array(
            'message' => $message,
            'alert-type' => 'success'
        );

        return redirect()->route('users.index')->with($notification);
    }

    public function destroy($id)
    {
        $user = Admin::findOrFail($id);
        $user->delete();
        $message = ' User deleted successfully.';
        $notification = array(
            'message' => $message,
            'alert-type' => 'success'
        );

        return redirect()->route('users.index')->with($notification);
    }
}

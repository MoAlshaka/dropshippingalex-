<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:All Roles', ['only' => ['index', 'store']]);
        $this->middleware('permission:Add Role', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit Role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Role', ['only' => ['destroy']]);
        $this->middleware('permission:Show Role', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('admin.roles.index', compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();


        if ($user->hasRole('Owner')) {
            $permission = Permission::all(); // Fetch all permissions

        } else {
            $permission = $user->getAllPermissions(); // Fetch user's permissions

        }


        return view('admin.roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array|exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $permissions = Permission::whereIn('id', $request->input('permission'))->get()->pluck('name')->toArray();

        $role->syncPermissions($permissions);


        return redirect()->route('roles.index')->with(['Add' => ' Role created successfully. ']);
    }

    /**
     * Disp    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('admin.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        if ($user->hasRole('Owner')) {
            $permission = Permission::all(); // Fetch all permissions
        } else {
            $permission = $user->getAllPermissions(); // Fetch user's permissions
        }

        $role = Role::find($id);
        $rolePermissions = DB::table("role_has_permissions")->where("role_id", $id)
            ->pluck('permission_id', 'permission_id')
            ->all();

        return view('admin.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            'permission' => 'required|array|exists:permissions,id',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $permissions = Permission::whereIn('id', $request->input('permission'))->get()->pluck('name')->toArray();

        $role->syncPermissions($permissions);



        return redirect()->route('roles.index')->with(['Update' => 'Role updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = DB::table("roles")->where('id', $id)->first();
        $admins = Admin::all();


        foreach ($admins as $admin) {
            if ($admin->roles_name == $role->name) {
                return redirect()->back()->with(['Warning' => 'This Role can not deleted beacuse it is used.']);
            }
        }


        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')->with(['Delete' => ' Role deleted successfully.']);
    }
}

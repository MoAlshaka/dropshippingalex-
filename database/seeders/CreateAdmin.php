<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = Admin::create([
            'name' => 'Easy Media',
            'username' => 'easymedia',
            'roles_name' => "Owner",
            'password' => Hash::make('admin@123'),
        ]);

        $role = Role::create(['name' => 'Owner', 'guard_name' => 'admin']);

        // Assign the "Owner" role to the user
        if ($role && !$admin->hasRole($role)) {
            $admin->assignRole($role);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create "admin" role
        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'admin']);

        // Assign all permissions to "admin" role
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);
    }
}

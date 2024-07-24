<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Dashboard',
            'Product Catalog',
            'Shared Product',
            'Affiliate Per Delivered',
            'Affiliate Per Confirmed',
            'Products',
            'Create Shared Product',
            'Edit Shared Product',
            'Delete Shared Product',
            'Create Affiliate Product',
            'Edit Affiliate Product',
            'Delete Affiliate Product',
            'Categories',
            'All Categories',
            'Create Category',
            'Edit Category',
            'Delete Category',
            'Countries',
            'All Countries',
            'Create Country',
            'Edit Country',
            'Delete Country',
            'Offers',
            'Create Offer',
            'Transaction',
            'All Transaction',
            'Create Transaction',
            'Edit Transaction',
            'Delete Transaction',
            'Sellers',
            'Show Seller',
            'Manage Seller',
            'Delete Seller',
            'Add Seller',
            'Leads',
            'All Leads',
            'Edit Lead',
            'Show Lead',
            'Delete Lead',
            'Orders',
            'All Orders',
            'Edit Order',
            'Show Orders',
            'Delete Orders',
            'Report',
            'Analytics',
            'Roles',
            'All Roles',
            'Add Role',
            'Edit Role',
            'Delete Role',
            'Show Role',
            'Admins',
            'All Admin',
            'Add Admin',
            'Edit Admin',
            'Delete Admin',
            'Invoices',
            'All Invoices',
            'Edit Invoices',
            'Delete Invoices',



        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }
    }
}

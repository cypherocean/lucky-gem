<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $company = Role::create(['name' => 'company']);
        $user = Role::create(['name' => 'user']);

        // Define permissions
        $permissions = [
            'create-companies', // Admin-only
            'update-companies', // Admin-only
            'delete-companies', // Admin-only
            'create-users',     // Admin and Company
            'update-users',     // Admin and Company
            'delete-users',     // Company only for users under its ID
            'view-companies',   // All roles
            'view-users',       // All roles
            'create-slot-machine',
            'update-slot-machine',
            'delete-slot-machine',
            'view-slot-machine',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $admin->givePermissionTo([
            'create-companies',
            'update-companies',
            'delete-companies',
            'create-users',
            'update-users',
            'view-companies',
            'view-users',
            'create-slot-machine',
            'update-slot-machine',
            'delete-slot-machine',
            'view-slot-machine',
        ]);

        $company->givePermissionTo([
            'create-users',
            'update-users',
            'delete-users',
            'view-companies',
            'view-users',
        ]);

        $user->givePermissionTo([
            'view-companies',
            'view-users',
            'create-slot-machine',
            'update-slot-machine',
            'delete-slot-machine',
            'view-slot-machine',
        ]);
    }
}

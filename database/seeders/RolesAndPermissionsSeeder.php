<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'access dashboard']);

        Permission::create(['name' => 'access users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'access roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'access grade level']);
        Permission::create(['name' => 'create grade level']);
        Permission::create(['name' => 'edit grade level']);
        Permission::create(['name' => 'delete grade level']);

        Permission::create(['name' => 'access section']);
        Permission::create(['name' => 'create section']);
        Permission::create(['name' => 'edit section']);
        Permission::create(['name' => 'delete section']);

        Permission::create(['name' => 'access students']);
        Permission::create(['name' => 'create students']);
        Permission::create(['name' => 'edit students']);
        Permission::create(['name' => 'delete students']);

        Permission::create(['name' => 'access profile']);
        Permission::create(['name' => 'edit profile']);

        // Create roles and assign existing permissions
        $superAdminRole = Role::create(['name' => 'admin']);
        $superAdminRole->givePermissionTo(Permission::all());
    }
}

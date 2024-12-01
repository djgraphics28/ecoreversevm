<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacultyRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles and assign existing permissions
        $facultyRole = Role::create(['name' => 'faculty']);
        $facultyRole->givePermissionTo([
            'access profile',
            'edit profile',
            'access student lists'
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create permissions
        $permissions = [
            'view dashboard',
            'view students', 'create students', 'edit students', 'delete students',
            'view classes', 'create classes', 'edit classes', 'delete classes',
            'view subjects', 'create subjects', 'edit subjects', 'delete subjects',
            'view results', 'create results', 'edit results', 'delete results',
            'view reports', 'generate reports',
            'manage users', 'manage roles', 'manage settings'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign created permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $teacherRole->givePermissionTo([
            'view dashboard',
            'view students', 'create students', 'edit students',
            'view classes', 'view subjects',
            'view results', 'create results', 'edit results',
            'view reports'
        ]);

        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $studentRole->givePermissionTo([
            'view dashboard',
            'view results',
            'view reports'
        ]);

        // Assign admin role to the first user
        $user = \App\Models\User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}

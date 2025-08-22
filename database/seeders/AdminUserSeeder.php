<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Define permissions
        $permissions = [
            'dashboard-access',
            'user-management',
            'result-management',
            'settings'
        ];

        // Create permissions and assign to admin role if they don't exist
        foreach ($permissions as $permission) {
            $permission = Permission::firstOrCreate(['name' => $permission]);
            if (!$adminRole->hasPermissionTo($permission)) {
                $adminRole->givePermissionTo($permission);
            }
        }

        // Create admin user
        // Update or create admin user with the specified password
        $admin = User::updateOrCreate(
            ['email' => 'kaushalkhadka789@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password1234@'),
            ]
        );

        // Assign admin role
        $admin->assignRole('admin');
    }
}

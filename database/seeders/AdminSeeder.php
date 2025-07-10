<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $modulesWithActions = [
            'Dashboard' => ['view'],
            'User' => ['view', 'add', 'edit', 'delete'],
            'HelpDesk' => ['view', 'add', 'respond', 'changeStatus'],
            'Contact' => ['view', 'edit', 'delete'],
            'Category' => ['view', 'add', 'edit', 'delete', 'changeStatus'],
            'ConfigSetting' => ['smtp', 'stripe', 'config', 'paypal'],
            'ContentPages' => ['view', 'edit'],
            'FAQ' => ['view', 'add', 'edit', 'delete', 'changeStatus'],
            'Notification' => ['view', 'read', 'delete'],
            'Newsletter' => ['view', 'delete', 'changeStatus'],
            'Announcements' => ['create', 'view', 'send', 'delete', 'changeStatus'],
            'Vouchers' => ['view', 'add', 'edit', 'delete', 'changeStatus'],
            'Feedback' => ['view', 'delete', 'changeStatus'],
            'Transaction' => ['view'],
            'Profile' => ['view', 'add', 'edit'],
        ];

        foreach ($modulesWithActions as $module => $actions) {
            foreach ($actions as $action) {
                $permission = Permission::firstOrCreate([
                    'name' => $action,
                ]);

                if (isset($permission->module) || \Schema::hasColumn('permissions', 'module')) {
                    $permission->module = $module;
                    $permission->save();
                }

                $adminRole->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }

        $adminUser = User::firstOrCreate([
            'email' => 'admin01@yopmail.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'), 
            'role_id' => $adminRole->id,
        ]);

        $adminUser->assignRole($adminRole);
    }
}

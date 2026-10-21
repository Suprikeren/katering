<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed the application's roles and permissions.
     */
    public function run(): void
    {
        $modules = ['user', 'role', 'permission'];
        $actions = ['index', 'create', 'update', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$module}.{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }

        $superAdmin = Role::findOrCreate('super-admin');
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::findOrCreate('admin');
        $admin->syncPermissions(
            Permission::query()
                ->whereIn('name', ['user.index', 'user.create', 'user.update'])
                ->get()
        );

        $member = Role::findOrCreate('member');
        $member->syncPermissions([]);
    }
}

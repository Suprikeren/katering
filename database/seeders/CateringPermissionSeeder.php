<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CateringPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan cache permission Spatie.
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar semua permission aplikasi katering.
        $permissions = [
            // Dashboard Super Admin dan Merchant
            'dashboard index',

            // Catering khusus Super Admin
            'merchants index',

            // Invoice Merchant
            'invoices index',
            'invoices show',

            // Menu Merchant
            'menus index',
            'menus create',
            'menus store',
            'menus edit',
            'menus update',
            'menus delete',

            // Order Merchant
            'orders index',
            'orders show',
            'orders update status',

            // Profil Merchant
            'profile edit',
            'profile update',
        ];

        // Buat permission jika belum tersedia.
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Ambil role yang sudah dibuat oleh seeder lama.
        $superAdmin = Role::findByName('super-admin', 'web');
        $merchant = Role::findByName('merchant', 'web');
        $customer = Role::findByName('customer', 'web');

        // Permission yang boleh digunakan Super Admin.
        $superAdmin->givePermissionTo([
            'dashboard index',
            'merchants index',
        ]);

        // Permission yang boleh digunakan Merchant.
        $merchant->givePermissionTo([
            'dashboard index',

            'invoices index',
            'invoices show',

            'menus index',
            'menus create',
            'menus store',
            'menus edit',
            'menus update',
            'menus delete',

            'orders index',
            'orders show',
            'orders update status',

            'profile edit',
            'profile update',
        ]);

        // Customer tidak mendapatkan permission baru ini.
        $customer->givePermissionTo([]);

        // Bersihkan kembali cache permission.
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}

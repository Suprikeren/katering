<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MerchantSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(CateringPermissionSeeder::class);

        // $user = User::query()->firstOrCreate(
        //     ['email' => 'super-admin@example.com'],
        //     [
        //         'name' => 'Test User',
        //         'password' => 'password',
        //     ],
        // );

        // $user->assignRole('super-admin');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role('customer')->get();

        foreach ($users as $user) {
            Customer::firstOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'company_name' => $user->name,
                    'address' => 'Alamat Customer',
                    'phone' => '080000000000',
                ]
            );
        }
    }
}

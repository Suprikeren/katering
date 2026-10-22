<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Merchant;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role('merchant')->get();

        $locations = [
            'Utan, Sumbawa',
            'Sumbawa',
            'Denpasar',
        ];

        foreach ($users as $index => $user) {
            Merchant::firstOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'company_name' => $user->name,
                    'address' => 'Alamat lengkap ' . $user->name,
                    'location' => $locations[$index % count($locations)],
                    'phone' => '080000000000',
                    'food_type' => 'Makanan Indonesia',
                    'description' => 'Usaha katering ' . $user->name,
                ]
            );
        }
    }
}

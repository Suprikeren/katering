<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Merchant;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $merchants = Merchant::all();

        foreach ($merchants as $merchant) {
            $menus = [
                [
                    'name' => 'Nasi Ayam Bakar',
                    'description' => 'Nasi putih dengan ayam bakar dan sambal',
                    'price' => 20000,
                ],
                [
                    'name' => 'Nasi Ayam Geprek',
                    'description' => 'Nasi dengan ayam geprek dan sambal pedas',
                    'price' => 18000,
                ],
                [
                    'name' => 'Nasi Rendang',
                    'description' => 'Nasi putih dengan rendang sapi',
                    'price' => 25000,
                ],
                [
                    'name' => 'Nasi Ikan Bakar',
                    'description' => 'Nasi dengan ikan bakar dan lalapan',
                    'price' => 22000,
                ],
                [
                    'name' => 'Nasi Telur Balado',
                    'description' => 'Nasi putih dengan telur balado',
                    'price' => 15000,
                ],
            ];

            foreach ($menus as $menu) {
                Menu::create([
                    'merchant_id' => $merchant->id,
                    'name' => $menu['name'],
                    'description' => $menu['description'],
                    'photo' => null,
                    'price' => $menu['price'],
                    'is_available' => 'yes',
                ]);
            }
        }
    }
}

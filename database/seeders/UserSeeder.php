<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's users.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => 'password',
                'role' => 'super-admin',
            ],
            [
                'name' => 'Merchant 1',
                'email' => 'merchant1@example.com',
                'password' => 'password',
                'role' => 'merchant',
            ],
            [
                'name' => 'Merchant 2',
                'email' => 'merchant2@example.com',
                'password' => 'password',
                'role' => 'merchant',
            ],
            [
                'name' => 'Merchant 3',
                'email' => 'merchant3@example.com',
                'password' => 'password',
                'role' => 'merchant',
            ],
            [
                'name' => 'Merchant 4',
                'email' => 'merchant4@example.com',
                'password' => 'password',
                'role' => 'merchant',
            ],
            [
                'name' => 'Customer 1',
                'email' => 'customer1@example.com',
                'password' => 'password',
                'role' => 'customer',
            ],
            [
                'name' => 'Customer 2',
                'email' => 'customer2@example.com',
                'password' => 'password',
                'role' => 'customer',
            ],
            [
                'name' => 'Customer 3',
                'email' => 'customer3@example.com',
                'password' => 'password',
                'role' => 'customer',
            ],
            [
                'name' => 'Customer 4',
                'email' => 'customer4@example.com',
                'password' => 'password',
                'role' => 'customer',
            ],
            [
                'name' => 'Customer 5',
                'email' => 'customer5@example.com',
                'password' => 'password',
                'role' => 'customer',
            ],
        ];

        foreach ($users as $data) {
            $role = Role::findOrCreate($data['role'], 'web');

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );

            $user->syncRoles([$role]);
        }
    }
}

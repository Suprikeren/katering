<?php

namespace App\Actions\Fortify;

use App\Models\Customer;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'account_type' => [
                'required',
                Rule::in(['customer', 'merchant']),
            ],
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            $role = $input['account_type'];

            $user->assignRole($role);

            if ($role === 'merchant') {
                Merchant::create([
                    'user_id' => $user->id,
                ]);
            } else {
                Customer::create([
                    'user_id' => $user->id,
                ]);
            }

            return $user;
        });
    }
}

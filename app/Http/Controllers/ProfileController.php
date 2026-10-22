<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function edit()
    {
        $customer = auth()->user()->customer;

        abort_if(!$customer, 404);

        return view('customer.profile.edit', compact('customer'));
    }

    public function update(Request $request)
    {
        $customer = auth()->user()->customer;

        abort_if(!$customer, 404);

        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        DB::transaction(function () use ($customer, $validated) {
            $customer->update($validated);
        });

        return redirect()
            ->route('home.profile.edit')
            ->with('success', 'Profil customer berhasil diperbarui.');
    }
}

<?php

namespace App\Http\Controllers\Dashboard\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class ProfileController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(
                PermissionMiddleware::using('profile edit'),
                only: ['edit']
            ),

            new Middleware(
                PermissionMiddleware::using('profile update'),
                only: ['update']
            ),
        ];
    }

    public function edit()
    {
        $merchant = auth()->user()->merchant;

        abort_if(!$merchant, 404);

        return view('dashboard.merchant.profile.edit', compact('merchant'));
    }

    public function update(Request $request)
    {
        $merchant = auth()->user()->merchant;

        abort_if(!$merchant, 404);

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'food_type' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $oldImages = [];
        $newImages = [];

        DB::transaction(function () use (
            $request,
            $merchant,
            &$validated,
            &$oldImages,
            &$newImages
        ) {
            foreach (['icon', 'thumbnail'] as $field) {
                if ($request->hasFile($field)) {
                    $oldImages[$field] = $merchant->$field;

                    $path = $request->file($field)
                        ->store("merchants/{$field}", 'public');

                    $newImages[] = $path;
                    $validated[$field] = $path;
                }
            }

            $merchant->update($validated);
        });

        // Hapus gambar lama setelah database berhasil diperbarui.
        foreach ($oldImages as $oldImage) {
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        return redirect()
            ->route('dashboard.merchant.profile.edit')
            ->with('success', 'Profil usaha berhasil diperbarui.');
    }
}

<?php

namespace App\Http\Controllers\Dashboard\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class MenuController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(
                PermissionMiddleware::using('menus index'),
                only: ['index']
            ),

            new Middleware(
                PermissionMiddleware::using('menus create'),
                only: ['create']
            ),

            new Middleware(
                PermissionMiddleware::using('menus store'),
                only: ['store']
            ),

            new Middleware(
                PermissionMiddleware::using('menus edit'),
                only: ['edit']
            ),

            new Middleware(
                PermissionMiddleware::using('menus update'),
                only: ['update']
            ),

            new Middleware(
                PermissionMiddleware::using('menus delete'),
                only: ['destroy']
            ),
        ];
    }

    public function index(Request $request)
    {
        $query = Menu::where(
            'merchant_id',
            auth()->user()->merchant->id
        );

        if ($request->search) {
            $query->search($request->search);
        }

        $menus = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.merchant.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('dashboard.merchant.menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'price' => 'required|integer|min:1',
            'is_available' => 'required|in:yes,no',
        ]);

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('menus', 'public');
        }

        Menu::create([
            'merchant_id' => auth()->user()->merchant->id,
            'name' => $request->name,
            'description' => $request->description,
            'photo' => $photo,
            'price' => $request->price,
            'is_available' => $request->is_available,
        ]);

        return redirect()
            ->route('dashboard.merchant.menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $menu = Menu::where('merchant_id', auth()->user()->merchant->id)
            ->findOrFail($id);

        return view('dashboard.merchant.menus.edit', compact('menu'));
    }

    public function update(Request $request, string $id)
    {
        $menu = Menu::where('merchant_id', auth()->user()->merchant->id)
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'price' => 'required|integer|min:1',
            'is_available' => 'required|in:yes,no',
        ]);

        if ($request->hasFile('photo')) {
            if ($menu->photo) {
                Storage::disk('public')->delete($menu->photo);
            }

            $menu->photo = $request->file('photo')->store('menus', 'public');
        }

        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->is_available = $request->is_available;

        $menu->save();

        return redirect()
            ->route('dashboard.merchant.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $menu = Menu::where('merchant_id', auth()->user()->merchant->id)
            ->findOrFail($id);

        if ($menu->photo) {
            Storage::disk('public')->delete($menu->photo);
        }

        $menu->delete();

        return redirect()
            ->route('dashboard.merchant.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $carts = Cart::with('menu.merchant')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $totalQuantity = $carts->sum('qty');
        $subtotal = $carts->sum('price');

        return view('customer.carts.index', compact(
            'carts',
            'totalQuantity',
            'subtotal'
        ));
    }

    public function store(Request $request)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty' => 'nullable|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $menu = Menu::where('is_available', 'yes')
                ->findOrFail($request->menu_id);

            $qty = $request->qty ?? 1;

            $cart = Cart::where('user_id', auth()->id())
                ->where('menu_id', $menu->id)
                ->lockForUpdate()
                ->first();

            if ($cart) {
                $cart->qty += $qty;
                $cart->price = $menu->price * $cart->qty;
                $cart->save();
            } else {
                Cart::create([
                    'user_id' => auth()->id(),
                    'menu_id' => $menu->id,
                    'qty' => $qty,
                    'price' => $menu->price * $qty,
                ]);
            }
        });

        return redirect()->back()->with(
            'success',
            'Menu berhasil ditambahkan ke keranjang!'
        )->withFragment('menu-list');
    }

    public function update(Request $request, string $id)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('user_id', auth()->id())
            ->with('menu')
            ->findOrFail($id);

        DB::transaction(function () use ($request, $cart) {
            $cart->qty = $request->qty;
            $cart->price = $cart->menu->price * $request->qty;
            $cart->save();
        });

        return redirect()
            ->route('home.cart')
            ->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->findOrFail($id);

        DB::transaction(function () use ($cart) {
            $cart->delete();
        });

        return redirect()
            ->route('home.cart')
            ->with('success', 'Menu berhasil dihapus dari keranjang.');
    }
}

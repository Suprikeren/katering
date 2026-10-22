<?php

namespace App\Http\Controllers\Dashboard\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(
                PermissionMiddleware::using('orders index'),
                only: ['index']
            ),

            new Middleware(
                PermissionMiddleware::using('orders show'),
                only: ['show']
            ),

            new Middleware(
                PermissionMiddleware::using('orders update status'),
                only: ['updateStatus']
            ),
        ];
    }

    /**
     * Menampilkan daftar pesanan merchant.
     */
    public function index(Request $request)
    {
        $merchant = auth()->user()->merchant;

        $orders = Order::with([
            'customer',
            'items',
            'invoice',
        ])
            ->where('merchant_id', $merchant->id)
            ->search($request->search)
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.merchant.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show($id)
    {
        $merchant = auth()->user()->merchant;

        $order = Order::with([
            'customer.user',
            'items',
            'invoice',
        ])
            ->where('merchant_id', $merchant->id)
            ->findOrFail($id);

        return view('dashboard.merchant.orders.show', compact('order'));
    }

    /**
     * Mengubah status pesanan.
     */
    public function updateStatus(Request $request, $id)
    {
        $merchant = auth()->user()->merchant;

        $order = Order::where('merchant_id', $merchant->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'confirmed',
                    'preparing',
                    'delivered',
                    'completed',
                    'cancelled',
                ]),
            ],
        ]);

        // Status final tidak dapat diubah lagi.
        if (in_array($order->status, ['completed', 'cancelled'])) {
            return back()->with(
                'error',
                'Status pesanan ini sudah final dan tidak dapat diubah.'
            );
        }

        // Alur perubahan status yang diperbolehkan.
        $allowedTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['preparing', 'cancelled'],
            'preparing' => ['delivered', 'cancelled'],
            'delivered' => ['completed'],
        ];

        if (! in_array(
            $validated['status'],
            $allowedTransitions[$order->status] ?? []
        )) {
            return back()->with(
                'error',
                'Perubahan status pesanan tidak diperbolehkan.'
            );
        }

        // Simpan perubahan status.
        $order->update([
            'status' => $validated['status'],
        ]);

        // Kembali ke halaman detail dan tampilkan SweetAlert.
        return redirect()
            ->route('dashboard.merchant.orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}

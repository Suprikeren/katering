<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // $customer = Customer::where('user_id', auth()->id())
        //     ->firstOrFail();
        $customer = Customer::where('user_id', auth()->id())
            ->first();

        $carts = Cart::with('menu.merchant')
            ->where('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()
                ->route('home.cart')
                ->with('error', 'Keranjang masih kosong.');
        }
        if (
            ! $customer ||
            empty($customer->company_name) ||
            empty($customer->phone) ||
            empty($customer->address)
        ) {
            return redirect()
                ->route('home.profile.edit')
                ->with('error', 'Lengkapi profil terlebih dahulu.');
        }

        $totalQuantity = $carts->sum('qty');
        $subtotal = $carts->sum('price');

        return view('customer.orders.checkout', compact(
            'customer',
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

        $customer = Customer::where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'delivery_date' => 'required|date|after_or_equal:today',
            'delivery_time' => 'required|date_format:H:i',
            'delivery_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $carts = Cart::with('menu.merchant')
            ->where('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()
                ->route('home.cart')
                ->with('error', 'Keranjang masih kosong.');
        }

        DB::transaction(function () use ($request, $customer, $carts) {
            foreach ($carts->groupBy('menu.merchant_id') as $merchantId => $items) {
                $total = 0;

                foreach ($items as $item) {
                    if (! $item->menu || $item->menu->is_available !== 'yes') {
                        throw new \Exception('Ada menu yang sudah tidak tersedia.');
                    }

                    $total += $item->menu->price * $item->qty;
                }

                $order = Order::create([
                    'merchant_id' => $merchantId,
                    'customer_id' => $customer->id,
                    'delivery_date' => $request->delivery_date,
                    'delivery_time' => $request->delivery_time,
                    'delivery_address' => $request->delivery_address,
                    'status' => 'pending',
                    'total' => $total,
                    'notes' => $request->notes,
                ]);

                foreach ($items as $item) {
                    $order->items()->create([
                        'menu_id' => $item->menu_id,
                        'menu_name' => $item->menu->name,
                        'price' => $item->menu->price,
                        'quantity' => $item->qty,
                        'subtotal' => $item->menu->price * $item->qty,
                    ]);
                }

                $issuedAt = Carbon::now();

                Invoice::create([
                    'order_id' => $order->id,
                    'invoice_number' => 'INV/'.$issuedAt->format('Ymd').'/'.
                        str_pad($order->id, 6, '0', STR_PAD_LEFT),
                    'issued_at' => $issuedAt,
                ]);
            }

            Cart::where('user_id', auth()->id())->delete();
        });

        return redirect()
            ->route('home.index')
            ->with('success', 'Pesanan dan invoice berhasil dibuat!');
    }

    public function invoices()
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $customer = Customer::where('user_id', auth()->id())
            ->firstOrFail();

        $invoices = Invoice::with('order.merchant')
            ->whereHas('order', function ($query) use ($customer) {
                $query->where('customer_id', $customer->id);
            })
            ->latest()
            ->get();

        return view('home.invoices.index', compact('invoices'));
    }

    public function showInvoice(string $id)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $customer = Customer::where('user_id', auth()->id())
            ->firstOrFail();

        $invoice = Invoice::with('order.merchant', 'order.items')
            ->whereHas('order', function ($query) use ($customer) {
                $query->where('customer_id', $customer->id);
            })
            ->findOrFail($id);

        return view('home.invoices.show', compact('invoice'));
    }
}

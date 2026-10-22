<?php

namespace App\Http\Controllers\Dashboard\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class InvoiceController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(
                PermissionMiddleware::using('invoices index'),
                only: ['index']
            ),

            new Middleware(
                PermissionMiddleware::using('invoices show'),
                only: ['show']
            ),
        ];
    }

    /**
     * Menampilkan daftar invoice milik merchant.
     */
    public function index(Request $request)
    {
        $merchant = auth()->user()->merchant;

        $invoices = Invoice::with([
            'order.customer',
            'order.items',
        ])
            ->whereHas('order', function ($query) use ($merchant) {
                $query->where('merchant_id', $merchant->id);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query->where('invoice_number', 'like', "%{$search}%")
                        ->orWhereHas('order', function ($query) use ($search) {
                            $query->where('id', 'like', "%{$search}%")
                                ->orWhereHas('customer', function ($query) use ($search) {
                                    $query->where('company_name', 'like', "%{$search}%");
                                });
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.merchant.invoices.index', compact('invoices'));
    }

    /**
     * Menampilkan detail invoice.
     */
    public function show($id)
    {
        $merchant = auth()->user()->merchant;

        $invoice = Invoice::with([
            'order.customer.user',
            'order.items',
            'order.merchant',
        ])
            ->whereHas('order', function ($query) use ($merchant) {
                $query->where('merchant_id', $merchant->id);
            })
            ->findOrFail($id);

        return view('dashboard.merchant.invoices.show', compact('invoice'));
    }
}

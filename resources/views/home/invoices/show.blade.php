
@extends('layouts.customer.app')

@section('content')
@php
    $order = $invoice->order;
    $merchant = $order->merchant;
@endphp

<div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

    <a href="{{ route('home.invoices') }}"
        class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-orange-600">
        &larr; Kembali ke Invoice Saya
    </a>

    <div class="mt-5 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 bg-gray-50 px-5 py-6 sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-medium text-orange-600">Detail Invoice</p>
                    <h1 class="mt-2 break-all text-xl font-bold text-gray-900">
                        {{ $invoice->invoice_number }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500">
                        Tanggal invoice:
                        {{ $invoice->issued_at->format('d F Y, H:i') }}
                    </p>
                </div>

                <span class="inline-flex w-fit rounded-full px-3 py-1.5 text-xs font-semibold
                    {{ $order->status === 'completed'
                        ? 'bg-green-100 text-green-700'
                        : ($order->status === 'cancelled'
                            ? 'bg-red-100 text-red-700'
                            : 'bg-orange-100 text-orange-700') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <div class="space-y-8 p-5 sm:p-8">

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <h2 class="text-sm font-bold text-gray-900">Informasi Merchant</h2>
                    <p class="mt-3 text-sm text-gray-600">
                        {{ $merchant->company_name ?? 'Merchant' }}
                    </p>
                </div>

                <div>
                    <h2 class="text-sm font-bold text-gray-900">Informasi Pengiriman</h2>
                    <p class="mt-3 text-sm text-gray-600">
                        Tanggal:
                        {{ \Carbon\Carbon::parse($order->delivery_date)->format('d F Y') }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600">
                        Waktu: {{ substr($order->delivery_time, 0, 5) }}
                    </p>
                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        {{ $order->delivery_address }}
                    </p>
                    @if ($order->notes)
                        <p class="mt-2 text-sm text-gray-500">
                            Catatan: {{ $order->notes }}
                        </p>
                    @endif
                </div>
            </div>

            <div>
                <h2 class="mb-4 text-sm font-bold text-gray-900">Rincian Pesanan</h2>

                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full min-w-[500px] text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Menu</th>
                                <th class="px-4 py-3 text-right font-semibold">Harga</th>
                                <th class="px-4 py-3 text-center font-semibold">Qty</th>
                                <th class="px-4 py-3 text-right font-semibold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-4 py-4 font-medium text-gray-800">
                                        {{ $item->menu_name }}
                                    </td>
                                    <td class="px-4 py-4 text-right text-gray-600">
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 text-center text-gray-600">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-4 py-4 text-right font-medium text-gray-800">
                                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-right font-bold text-gray-900">
                                    Total Tagihan
                                </td>
                                <td class="px-4 py-4 text-right text-base font-bold text-orange-600">
                                    Rp{{ number_format($order->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="rounded-xl border border-orange-100 bg-orange-50 p-4">
                <h2 class="text-sm font-bold text-gray-900">Informasi Pembayaran</h2>
                <p class="mt-2 text-sm leading-6 text-gray-600">
                    Silakan ikuti instruksi pembayaran dari merchant. Fitur unggah bukti
                    pembayaran dapat ditambahkan setelah alur invoice ini selesai.
                </p>
            </div>

        </div>
    </div>
</div>
@endsection

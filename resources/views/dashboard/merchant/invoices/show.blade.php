
@extends('layouts.admins.app')

@section('content')

@php
    $order = $invoice->order;
    $merchant = $order->merchant;

    $statusLabels = [
        'pending' => 'Menunggu',
        'confirmed' => 'Dikonfirmasi',
        'preparing' => 'Disiapkan',
        'delivered' => 'Dikirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    $statusClasses = [
        'pending' => 'bg-orange-50 text-orange-600',
        'confirmed' => 'bg-blue-50 text-blue-600',
        'preparing' => 'bg-purple-50 text-purple-600',
        'delivered' => 'bg-cyan-50 text-cyan-600',
        'completed' => 'bg-green-50 text-green-600',
        'cancelled' => 'bg-red-50 text-red-600',
    ];
@endphp

@include('dashboard.partials.header', [
    'title' => 'Detail Invoice',
    'subtitle' => 'Lihat rincian tagihan dan informasi pesanan',
    'createLabel' => 'Kembali',
    'createUrl' => route('dashboard.merchant.invoices.index'),
])

<div class="col-span-12">
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">

        {{-- Header Invoice --}}
        <div class="flex flex-col gap-4 border-b border-gray-200 bg-gray-50 px-5 py-6 dark:border-gray-800 dark:bg-gray-800/50 sm:flex-row sm:items-start sm:justify-between sm:px-8">
            <div>
                <p class="text-sm font-medium text-orange-600">
                    Detail Invoice
                </p>

                <h1 class="mt-2 break-all text-xl font-bold text-gray-900 dark:text-white">
                    {{ $invoice->invoice_number }}
                </h1>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Tanggal invoice:
                    {{ $invoice->issued_at
                        ? \Carbon\Carbon::parse($invoice->issued_at)->format('d F Y, H:i')
                        : '-' }}
                </p>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Nomor pesanan: #{{ $order->id }}
                </p>
            </div>

            <span class="inline-flex w-fit rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
            </span>
        </div>

        <div class="space-y-8 p-5 sm:p-8">

            {{-- Informasi Merchant dan Pengiriman --}}
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                        Informasi Merchant
                    </h2>

                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ $merchant->company_name ?? 'Merchant' }}
                    </p>
                </div>

                <div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                        Informasi Pengiriman
                    </h2>

                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        Tanggal:
                        {{ $order->delivery_date
                            ? \Carbon\Carbon::parse($order->delivery_date)->format('d F Y')
                            : '-' }}
                    </p>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Waktu:
                        {{ $order->delivery_time
                            ? substr($order->delivery_time, 0, 5)
                            : '-' }}
                    </p>

                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                        {{ $order->delivery_address ?? '-' }}
                    </p>

                    @if ($order->notes)
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Catatan: {{ $order->notes }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Rincian Pesanan --}}
            <div>
                <h2 class="mb-4 text-sm font-bold text-gray-900 dark:text-white">
                    Rincian Pesanan
                </h2>

                <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-800">
                    <table class="w-full min-w-[500px] text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Menu</th>
                                <th class="px-4 py-3 text-right font-semibold">Harga</th>
                                <th class="px-4 py-3 text-center font-semibold">Qty</th>
                                <th class="px-4 py-3 text-right font-semibold">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse ($order->items as $item)
                                <tr>
                                    <td class="px-4 py-4 font-medium text-gray-800 dark:text-white">
                                        {{ $item->menu_name }}
                                    </td>

                                    <td class="px-4 py-4 text-right text-gray-600 dark:text-gray-400">
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-4 text-center text-gray-600 dark:text-gray-400">
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="px-4 py-4 text-right font-medium text-gray-800 dark:text-white">
                                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada rincian menu.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-right font-bold text-gray-900 dark:text-white">
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

            {{-- Informasi Pembayaran --}}
            <div class="rounded-xl border border-orange-100 bg-orange-50 p-4 dark:border-orange-500/20 dark:bg-orange-500/5">
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                    Informasi Pembayaran
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    Silakan ikuti instruksi pembayaran yang berlaku.
                    Fitur unggah bukti pembayaran dapat ditambahkan setelah
                    alur invoice ini selesai.
                </p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex flex-wrap justify-end gap-3 border-t border-gray-200 pt-6 dark:border-gray-800 print:hidden">
                <a href="{{ route('dashboard.merchant.invoices.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                    Kembali
                </a>

                <button type="button"
                    onclick="window.print()"
                    class="inline-flex items-center justify-center rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-orange-600">
                    Cetak Invoice
                </button>
            </div>

        </div>
    </div>
</div>

<style>
    @media print {
        body {
            background: white !important;
        }

        body * {
            visibility: hidden;
        }

        .col-span-12,
        .col-span-12 * {
            visibility: visible;
        }

        .col-span-12 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }

        .col-span-12 > div {
            box-shadow: none !important;
            border: none !important;
        }

        @page {
            size: A4;
            margin: 15mm;
        }
    }
</style>

@endsection

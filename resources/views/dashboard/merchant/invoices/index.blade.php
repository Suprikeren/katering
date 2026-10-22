@extends('layouts.admins.app')

@section('content')

@include('dashboard.partials.header', [
    'title' => 'Invoice',
    'subtitle' => 'Kelola dan lihat tagihan pesanan pelanggan',
])

@php
    $statusLabels = [
        'pending' => 'Menunggu',
        'confirmed' => 'Dikonfirmasi',
        'preparing' => 'Disiapkan',
        'delivered' => 'Dikirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    $statusClasses = [
        'pending' => 'bg-orange-50 text-orange-600 dark:bg-orange-500/10 dark:text-orange-400',
        'confirmed' => 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400',
        'preparing' => 'bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400',
        'delivered' => 'bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400',
        'completed' => 'bg-green-50 text-green-600 dark:bg-green-500/10 dark:text-green-400',
        'cancelled' => 'bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400',
    ];
@endphp

<div class="col-span-12">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">

        {{-- Toolbar --}}
        <div class="flex flex-col gap-4 border-b border-gray-200 px-5 py-5 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <form action="{{ route('dashboard.merchant.invoices.index') }}"
                method="GET"
                class="flex w-full flex-col gap-3 sm:max-w-2xl sm:flex-row">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nomor invoice, ID pesanan, pelanggan..."
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 dark:border-gray-700 dark:text-white sm:flex-1"
                >

                <div class="flex gap-2">
                    <button type="submit"
                        class="inline-flex h-11 items-center justify-center rounded-lg bg-orange-500 px-5 text-sm font-medium text-white hover:bg-orange-600">
                        Cari
                    </button>

                    <a href="{{ route('dashboard.merchant.invoices.index') }}"
                        class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                        Reset
                    </a>
                </div>
            </form>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Total {{ $invoices->total() }} invoice
            </p>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase text-gray-500 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Invoice</th>
                        <th class="px-5 py-4 font-semibold">Pelanggan</th>
                        <th class="px-5 py-4 font-semibold">Tanggal Invoice</th>
                        <th class="px-5 py-4 text-right font-semibold">Total Tagihan</th>
                        <th class="px-5 py-4 text-center font-semibold">Status Pesanan</th>
                        <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($invoices as $invoice)
                        @php
                            $order = $invoice->order;
                        @endphp

                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <td class="px-5 py-4">
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $invoice->invoice_number }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Order #{{ $order->id }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-800 dark:text-white">
                                    {{ $order->customer->company_name ?? 'Pelanggan' }}
                                </p>
                            </td>

                            <td class="px-5 py-4 text-gray-600 dark:text-gray-400">
                                {{ $invoice->issued_at
                                    ? \Carbon\Carbon::parse($invoice->issued_at)->format('d M Y, H:i')
                                    : '-' }}
                            </td>

                            <td class="px-5 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                Rp{{ number_format($order->total ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300' }}">
                                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <a href="{{ route('dashboard.merchant.invoices.show', $invoice->id) }}"
                                    class="inline-flex items-center justify-center rounded-lg border border-orange-200 px-3 py-2 text-xs font-medium text-orange-600 transition hover:bg-orange-50 dark:border-orange-500/30 dark:text-orange-400 dark:hover:bg-orange-500/10">
                                    Detail Invoice
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14h6m-6-4h6m2 10H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v9a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>

                                    <p class="font-semibold text-gray-800 dark:text-white">
                                        Belum ada invoice
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Invoice pesanan akan muncul di sini setelah dibuat.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($invoices->hasPages())
            <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800 sm:px-6">
                {{ $invoices->links() }}
            </div>
        @endif

    </div>
</div>

@endsection

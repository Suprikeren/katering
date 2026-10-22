@extends('layouts.admins.app')

@section('content')
    @include('dashboard.partials.header', [
        'title' => 'Orders',
        'subtitle' => 'Kelola pesanan katering dari pelanggan',
    ])

    <div class="col-span-12">
        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">

            {{-- Toolbar --}}
            <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">
                <form
                    method="GET"
                    action="{{ route('dashboard.merchant.orders.index') }}"
                    class="flex flex-wrap items-center gap-2"
                >
                    <div class="relative">
                        <svg
                            class="absolute top-1/2 left-3.5 -translate-y-1/2 fill-gray-400"
                            width="16"
                            height="16"
                            viewBox="0 0 16 16"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M7.16675 2.75C4.72752 2.75 2.75008 4.72744 2.75008 7.16667C2.75008 9.6059 4.72752 11.5833 7.16675 11.5833C8.30958 11.5833 9.35439 11.1726 10.1797 10.4789L12.1005 12.3997C12.3956 12.6947 12.8704 12.6947 13.1655 12.3997L11.2447 9.41388C11.9384 8.58858 12.3491 7.54377 12.3491 6.40094C12.3491 4.96169 11.2257 3.71283 9.83968 3.61973C9.59268 2.75028 8.78832 2.16667 7.86083 2.16667H7.16675V2.75ZM7.16675 4.25C5.55592 4.25 4.25008 5.55584 4.25008 7.16667C4.25008 8.7775 5.55592 10.0833 7.16675 10.0833C8.77758 10.0833 10.0834 8.7775 10.0834 7.16667C10.0834 5.55584 8.77758 4.25 7.16675 4.25Z"
                            />
                        </svg>

                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari invoice atau pelanggan..."
                            class="h-10 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-4 pl-9 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 dark:border-gray-800 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30 sm:w-64"
                        >
                    </div>

                    <select
                        name="status"
                        class="h-10 rounded-lg border border-gray-200 bg-transparent px-3 py-2 text-sm text-gray-700 outline-none focus:border-brand-300 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300"
                    >
                        <option value="">Semua Status</option>
                        <option value="pending" @selected(request('status') === 'pending')>
                            Pending
                        </option>
                        <option value="confirmed" @selected(request('status') === 'confirmed')>
                            Dikonfirmasi
                        </option>
                        <option value="preparing" @selected(request('status') === 'preparing')>
                            Disiapkan
                        </option>
                        <option value="delivered" @selected(request('status') === 'delivered')>
                            Dikirim
                        </option>
                        <option value="completed" @selected(request('status') === 'completed')>
                            Selesai
                        </option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>
                            Dibatalkan
                        </option>
                    </select>

                    <button
                        type="submit"
                        class="rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        Cari
                    </button>

                    @if (request('search') != null && request('search') != '' || request('status') != null && request('status') != '')
                        <a
                            href="{{ route('dashboard.merchant.orders.index') }}"
                            class="text-theme-sm font-medium text-gray-500 transition hover:text-brand-500 dark:text-gray-400"
                        >
                            Reset
                        </a>
                    @endif
                </form>

                <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                    Menampilkan {{ $orders->total() }} pesanan
                </p>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left">
                    <thead class="border-b border-gray-200 dark:border-gray-800">
                        <tr class="bg-gray-50 dark:bg-gray-800/40">
                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Invoice
                            </th>
                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Pelanggan
                            </th>
                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Pengiriman
                            </th>
                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Total
                            </th>
                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Status
                            </th>
                            <th class="px-5 py-3 text-right text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($orders as $order)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-white/5">

                                {{-- Invoice --}}
                                <td class="px-5 py-4">
                                    <span class="font-medium text-gray-800 dark:text-white/90">
                                        {{ $order->invoice?->invoice_number ?? '-' }}
                                    </span>

                                    <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                                        Pesanan #{{ $order->id }}
                                    </p>
                                </td>

                                {{-- Pelanggan --}}
                                <td class="px-5 py-4">
                                    <span class="font-medium text-gray-800 dark:text-white/90">
                                        {{ $order->customer?->company_name ?? 'Pelanggan' }}
                                    </span>

                                    <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                                        {{ $order->customer?->phone ?? '-' }}
                                    </p>
                                </td>

                                {{-- Pengiriman --}}
                                <td class="px-5 py-4 text-theme-sm text-gray-500 dark:text-gray-400">
                                    <p class="text-gray-800 dark:text-white/90">
                                        {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}
                                    </p>

                                    <p class="mt-1">
                                        {{ $order->delivery_time }}
                                    </p>
                                </td>

                                {{-- Total --}}
                                <td class="px-5 py-4 text-theme-sm text-gray-500 dark:text-gray-400">
                                    Rp{{ number_format($order->total, 0, ',', '.') }}
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4">
                                    @php
                                        $statusStyles = [
                                            'pending' => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400',
                                            'confirmed' => 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400',
                                            'preparing' => 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400',
                                            'delivered' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400',
                                            'completed' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400',
                                            'cancelled' => 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400',
                                        ];

                                        $statusLabels = [
                                            'pending' => 'Pending',
                                            'confirmed' => 'Dikonfirmasi',
                                            'preparing' => 'Disiapkan',
                                            'delivered' => 'Dikirim',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp

                                    <span class="rounded-full px-2.5 py-1 text-theme-xs font-medium {{ $statusStyles[$order->status] ?? 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                                        {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end">
                                        <a
                                            href="{{ route('dashboard.merchant.orders.show', $order->id) }}"
                                            title="Detail Pesanan"
                                            class="inline-flex h-9 items-center justify-center gap-2 rounded-lg border border-gray-300 px-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
                                        >
                                            <svg
                                                width="16"
                                                height="16"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path d="M10 4.16667C5.83333 4.16667 2.5 10 2.5 10S5.83333 15.8333 10 15.8333 17.5 10 17.5 10 14.1667 4.16667 10 4.16667ZM10 13.3333A3.33333 3.33333 0 1 1 10 6.66667a3.33333 3.33333 0 0 1 0 6.66666Z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    @include('dashboard.partials.empty-state', [
                                        'message' => request('search') || request('status')
                                            ? 'Pesanan tidak ditemukan.'
                                            : 'Belum ada pesanan.',
                                    ])
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection


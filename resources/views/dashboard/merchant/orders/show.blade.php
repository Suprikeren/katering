@extends('layouts.admins.app')

@section('content')
    @include('dashboard.partials.header', [
        'title' => 'Detail Pesanan',
        'subtitle' => 'Lihat detail dan kelola status pesanan',
        'createLabel' => 'Kembali',
        'createUrl' => route('dashboard.merchant.orders.index'),
    ])

    <div class="col-span-12 space-y-6">

        {{-- Informasi Pesanan --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                    Informasi Pesanan
                </h3>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Nomor Invoice</p>
                    <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        {{ $order->invoice?->invoice_number ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">ID Pesanan</p>
                    <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        #{{ $order->id }}
                    </p>
                </div>

                <div>
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Tanggal Pesanan</p>
                    <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        {{ $order->created_at?->format('d M Y, H:i') ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Tanggal Pengiriman</p>
                    <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        {{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') : '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Waktu Pengiriman</p>
                    <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        {{ $order->delivery_time ?: '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Status Saat Ini</p>

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

                    <span class="mt-2 inline-flex rounded-full px-2.5 py-1 text-theme-xs font-medium {{ $statusStyles[$order->status] ?? 'bg-gray-100 text-gray-500' }}">
                        {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Informasi Pelanggan --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                    Informasi Pelanggan
                </h3>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2">
                <div>
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Nama Perusahaan</p>
                    <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        {{ $order->customer?->company_name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Nomor Telepon</p>
                    <p class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        {{ $order->customer?->phone ?? '-' }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Alamat Pengiriman</p>
                    <p class="mt-1 text-sm text-gray-800 dark:text-white/90">
                        {{ $order->delivery_address ?: '-' }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-theme-sm text-gray-500 dark:text-gray-400">Catatan Pesanan</p>
                    <p class="mt-1 text-sm text-gray-800 dark:text-white/90">
                        {{ $order->notes ?: 'Tidak ada catatan.' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Daftar Menu Pesanan --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                    Daftar Menu Pesanan
                </h3>
                <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                    Rincian menu yang dipesan pelanggan.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px] text-left">
                    <thead class="border-b border-gray-200 dark:border-gray-800">
                        <tr class="bg-gray-50 dark:bg-gray-800/40">
                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Nama Menu
                            </th>
                            <th class="px-5 py-3 text-right text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Harga
                            </th>
                            <th class="px-5 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Jumlah
                            </th>
                            <th class="px-5 py-3 text-right text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Subtotal
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($order->items as $item)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-5 py-4">
                                    <span class="font-medium text-gray-800 dark:text-white/90">
                                        {{ $item->menu_name }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-right text-theme-sm text-gray-500 dark:text-gray-400">
                                    Rp{{ number_format($item->price, 0, ',', '.') }}
                                </td>

                                <td class="px-5 py-4 text-center text-theme-sm text-gray-500 dark:text-gray-400">
                                    {{ $item->quantity }}
                                </td>

                                <td class="px-5 py-4 text-right text-theme-sm font-medium text-gray-800 dark:text-white/90">
                                    Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    @include('dashboard.partials.empty-state', [
                                        'message' => 'Belum ada item pada pesanan ini.',
                                    ])
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot class="border-t border-gray-200 dark:border-gray-800">
                        <tr>
                            <td colspan="3" class="px-5 py-4 text-right text-sm font-semibold text-gray-800 dark:text-white/90">
                                Total Pesanan
                            </td>
                            <td class="px-5 py-4 text-right text-base font-semibold text-brand-500">
                                Rp{{ number_format($order->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Ubah Status --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                    Ubah Status Pesanan
                </h3>
                <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                    Perbarui status sesuai proses pesanan.
                </p>
            </div>

            <div class="p-5">
                @if (in_array($order->status, ['completed', 'cancelled']))
                    <p class="rounded-lg bg-gray-50 px-4 py-3 text-sm text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                        Pesanan ini sudah {{ $statusLabels[$order->status] ?? $order->status }}
                        dan tidak dapat diubah lagi.
                    </p>
                @else
                    @php
                        $allowedStatuses = [
                            'pending' => [
                                'confirmed' => 'Dikonfirmasi',
                                'cancelled' => 'Dibatalkan',
                            ],
                            'confirmed' => [
                                'preparing' => 'Disiapkan',
                                'cancelled' => 'Dibatalkan',
                            ],
                            'preparing' => [
                                'delivered' => 'Dikirim',
                                'cancelled' => 'Dibatalkan',
                            ],
                            'delivered' => [
                                'completed' => 'Selesai',
                            ],
                        ];

                        $nextStatuses = $allowedStatuses[$order->status] ?? [];
                    @endphp

                    @if (count($nextStatuses))
                        <form
                            method="POST"
                            action="{{ route('dashboard.merchant.orders.update-status', $order->id) }}"
                            class="flex flex-col gap-4 sm:flex-row sm:items-end"
                            data-confirm="Status pesanan akan diubah."
                            data-confirm-title="Ubah Status Pesanan"
                        >
                            @csrf
                            @method('PATCH')

                            <div class="w-full sm:max-w-xs">
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Status Baru
                                </label>

                                <select
                                    name="status"
                                    required
                                    class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 dark:border-gray-800 dark:bg-gray-900 dark:text-white/90"
                                >
                                    <option value="">Pilih status</option>

                                    @foreach ($nextStatuses as $value => $label)
                                        <option value="{{ $value }}">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button
                                type="submit"
                                class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-5 text-sm font-medium text-white transition hover:bg-brand-600"
                            >
                                Simpan Status
                            </button>
                        </form>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Tidak ada perubahan status yang tersedia.
                        </p>
                    @endif
                @endif
            </div>
        </div>

    </div>
@endsection


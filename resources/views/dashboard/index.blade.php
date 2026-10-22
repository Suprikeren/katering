@extends('layouts.admins.app')

@section('content')
    @if (auth()->user()->hasRole('super-admin'))
        <div class="col-span-12">
            <h1>Selamat datang super-admin</h1>
        </div>

    @elseif (auth()->user()->hasRole('merchant'))
        @php
            $merchant = auth()->user()->merchant;

            $totalMenus = $merchant ? $merchant->menus()->count() : 0;
            $totalOrders = $merchant ? $merchant->orders()->count() : 0;
            $pendingOrders = $merchant
                ? $merchant->orders()->where('status', 'pending')->count()
                : 0;
            $completedOrders = $merchant
                ? $merchant->orders()->where('status', 'completed')->count()
                : 0;
        @endphp

        <div class="col-span-12 space-y-6">

            {{-- Header Dashboard --}}
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                        Dashboard Merchant
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan usaha katering Anda.
                    </p>
                </div>

                <a href="{{ route('dashboard.merchant.menus.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white hover:bg-brand-600">
                    <span class="text-lg">+</span>
                    Tambah Menu
                </a>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Menu</p>
                    <h3 class="mt-3 text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $totalMenus }}
                    </h3>
                    <a href="{{ route('dashboard.merchant.menus.index') }}"
                        class="mt-4 inline-block text-sm font-medium text-brand-500">
                        Kelola menu →
                    </a>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Pesanan</p>
                    <h3 class="mt-3 text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $totalOrders }}
                    </h3>
                    <a href="{{ route('dashboard.merchant.orders.index') }}"
                        class="mt-4 inline-block text-sm font-medium text-brand-500">
                        Lihat pesanan →
                    </a>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Menunggu Konfirmasi</p>
                    <h3 class="mt-3 text-3xl font-bold text-amber-500">
                        {{ $pendingOrders }}
                    </h3>
                    <a href="{{ route('dashboard.merchant.orders.index', ['status' => 'pending']) }}"
                        class="mt-4 inline-block text-sm font-medium text-amber-600">
                        Periksa pesanan →
                    </a>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pesanan Selesai</p>
                    <h3 class="mt-3 text-3xl font-bold text-emerald-500">
                        {{ $completedOrders }}
                    </h3>
                    <a href="{{ route('dashboard.merchant.orders.index', ['status' => 'completed']) }}"
                        class="mt-4 inline-block text-sm font-medium text-emerald-600">
                        Lihat riwayat →
                    </a>
                </div>

            </div>

            {{-- Banner --}}
            <div class="rounded-2xl bg-gradient-to-r from-brand-600 to-brand-500 p-6 text-white md:p-8">
                <p class="text-sm font-medium text-white/80">PENGELOLAAN USAHA</p>
                <h3 class="mt-2 text-2xl font-bold">
                    Kelola pesanan katering dengan mudah
                </h3>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-white/80">
                    Pantau pesanan masuk, perbarui status pemrosesan, dan kelola menu
                    agar operasional usaha Anda tetap teratur.
                </p>
                <a href="{{ route('dashboard.merchant.orders.index') }}"
                    class="mt-5 inline-flex rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-brand-600 hover:bg-gray-100">
                    Lihat Semua Pesanan →
                </a>
            </div>

            {{-- Akses Cepat --}}
            <div>
                <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">
                    Akses Cepat
                </h3>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                    <a href="{{ route('dashboard.merchant.menus.index') }}"
                        class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 transition hover:border-brand-500 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-xl dark:bg-blue-500/10">
                            🍱
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">Kelola Menu</h4>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Atur daftar menu katering
                            </p>
                        </div>
                    </a>

                    <a href="{{ route('dashboard.merchant.orders.index') }}"
                        class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 transition hover:border-brand-500 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-xl dark:bg-violet-500/10">
                            📋
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">Kelola Pesanan</h4>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Periksa pesanan pelanggan
                            </p>
                        </div>
                    </a>

                    <a href="{{ route('dashboard.merchant.invoices.index') }}"
                        class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 transition hover:border-brand-500 dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-xl dark:bg-emerald-500/10">
                            🧾
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">Invoice</h4>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Periksa tagihan pesanan
                            </p>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    @endif
@endsection

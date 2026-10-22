@extends('layouts.customer.app')

@section('title', 'Detail Katering')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- PROFIL CATERING --}}
        <section class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="h-56 sm:h-72">
                <img src="{{ asset('storage/' . $merchant->thumbnail) }}" alt="{{ $merchant->company_name }}"
                    class="h-full w-full object-cover">
            </div>

            <div class="p-5 sm:p-8">
                <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                    <div>
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                            Katering tersedia
                        </span>

                        <h1 class="mt-3 text-2xl font-extrabold text-gray-900 sm:text-3xl">
                            {{ $merchant->company_name }}
                        </h1>

                        <p class="mt-2 text-sm text-gray-500">
                            {{ $merchant->address }}
                        </p>

                        <p class="mt-3 max-w-2xl text-sm leading-6 text-gray-600">
                            {{ $merchant->description }}
                        </p>
                    </div>

                    <a href="{{ route('home.index') }}"
                        class="inline-flex shrink-0 justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        ← Kembali
                    </a>
                </div>
            </div>
        </section>

        {{-- DAFTAR MENU --}}
        <section id="menu-list" class="mt-10 scroll-mt-6">
            <div class="mb-6">
                <p class="text-xs font-bold tracking-widest text-orange-600">
                    MENU KAMI
                </p>

                <h2 class="mt-2 text-2xl font-extrabold text-gray-900">
                    Pilihan Menu
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Pilih menu favoritmu dari {{ $merchant->company_name }}.
                </p>
            </div>

            {{-- PESAN SUKSES --}}
            @if (session('success'))
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- PESAN ERROR --}}
            @if (session('error'))
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($menus as $menu)
                    <article
                        class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition hover:shadow-lg">
                        <div class="relative h-48">
                            @if ($menu->photo)
                                <img src="{{ asset('storage/' . $menu->photo) }}" alt="{{ $menu->name }}" loading="lazy"
                                    class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center bg-gray-100 text-sm text-gray-400">
                                    Foto menu belum tersedia
                                </div>
                            @endif

                            @if ($menu->is_available === 'no')
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                                    <span class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-800">
                                        Stok Habis
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-900">
                                {{ $menu->name }}
                            </h3>

                            <p class="mt-2 min-h-12 text-sm leading-6 text-gray-500">
                                {{ $menu->description }}
                            </p>

                            <div class="mt-4 flex items-center justify-between gap-3 border-t border-gray-100 pt-4">
                                <div>
                                    <p class="text-xs text-gray-500">
                                        Harga per porsi
                                    </p>

                                    <p class="mt-1 text-lg font-extrabold text-orange-600">
                                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                @if ($menu->is_available === 'yes')
                                    <form action="{{ route('home.cart.store') }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                                        <input type="hidden" name="qty" value="1">

                                        <button type="submit"
                                            class="rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-orange-600">
                                            + Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button type="button" disabled
                                        class="cursor-not-allowed rounded-xl bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-400">
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center">
                        <h3 class="text-lg font-bold text-gray-800">
                            Belum Ada Menu
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Katering ini belum memiliki menu yang tersedia.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>
        <div class="mt-8">
            {{ $menus->links() }}
        </div>

    </div>
@endsection

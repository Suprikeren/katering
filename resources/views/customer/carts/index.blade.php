@extends('layouts.customer.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-8">
            <p class="text-sm font-semibold text-orange-600">
                PESANAN ANDA
            </p>

            <h1 class="mt-2 text-3xl font-extrabold text-gray-900">
                Keranjang Belanja
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Periksa menu pilihanmu sebelum melanjutkan pesanan.
            </p>
        </div>

        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-3">

            {{-- ITEM KERANJANG --}}
            <section class="space-y-5 lg:col-span-2">

                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">
                        Menu Pilihan
                    </h2>

                    <span class="text-sm text-gray-500">
                        {{ $totalQuantity }} item
                    </span>
                </div>

                @forelse ($carts as $item)
                    <article class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5">
                        <div class="flex gap-4">

                            {{-- FOTO MENU --}}
                            @if ($item->menu && $item->menu->photo)
                                <img src="{{ asset('storage/' . $item->menu->photo) }}" alt="{{ $item->menu->name }}"
                                    class="h-24 w-24 shrink-0 rounded-xl object-cover sm:h-28 sm:w-28">
                            @else
                                <div
                                    class="flex h-24 w-24 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-orange-400 sm:h-28 sm:w-28">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 3h18v18H3z M3 16l5-5 4 4 3-3 6 6" />
                                    </svg>
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">

                                {{-- MERCHANT --}}
                                <p class="text-xs font-medium text-orange-600">
                                    {{ $item->menu?->merchant?->company_name ?? 'Merchant' }}
                                </p>

                                {{-- NAMA MENU --}}
                                <h3 class="mt-1 font-bold text-gray-900">
                                    {{ $item->menu?->name ?? 'Menu tidak tersedia' }}
                                </h3>

                                {{-- DESKRIPSI --}}
                                <p class="mt-1 text-xs leading-5 text-gray-500">
                                    {{ $item->menu?->description ?? 'Tidak ada deskripsi menu.' }}
                                </p>

                                {{-- HARGA SATUAN --}}
                                <p class="mt-3 text-sm font-semibold text-gray-900">
                                    Rp{{ number_format($item->menu?->price ?? 0, 0, ',', '.') }}
                                    <span class="font-normal text-gray-500">/ porsi</span>
                                </p>

                                {{-- QTY DAN HAPUS --}}
                                <div class="mt-4 flex flex-wrap items-center justify-between gap-3">

                                    {{-- UPDATE QTY --}}
                                    <form action="{{ route('home.cart.update', $item->id) }}" method="POST"
                                        class="quantity-form flex items-center rounded-xl border border-gray-200">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="qty" value="{{ $item->qty }}">

                                        <button type="button"
                                            class="quantity-btn px-3 py-2 text-gray-600 hover:text-orange-600"
                                            data-action="decrease" aria-label="Kurangi jumlah">
                                            −
                                        </button>

                                        <span class="quantity w-8 text-center text-sm font-semibold">
                                            {{ $item->qty }}
                                        </span>

                                        <button type="button"
                                            class="quantity-btn px-3 py-2 text-gray-600 hover:text-orange-600"
                                            data-action="increase" aria-label="Tambah jumlah">
                                            +
                                        </button>
                                    </form>

                                    {{-- HAPUS ITEM --}}
                                    <form action="{{ route('home.cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </div>

                                {{-- SUBTOTAL ITEM --}}
                                <p class="mt-3 text-sm text-gray-500">
                                    Subtotal:
                                    <span class="font-bold text-gray-900">
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </article>
                @empty

                    {{-- KERANJANG KOSONG --}}
                    <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-5 py-12 text-center">

                        <div class="flex justify-center text-orange-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l2.4 12.2a2 2 0 002 1.6h8.8a2 2 0 002-1.6L22 8H6" />
                                <circle cx="10" cy="21" r="1" />
                                <circle cx="18" cy="21" r="1" />
                            </svg>
                        </div>

                        <h3 class="mt-4 text-lg font-bold text-gray-900">
                            Keranjangmu masih kosong
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Yuk, pilih menu katering yang kamu suka.
                        </p>

                        <a href="{{ route('home.caterings') }}"
                            class="mt-5 inline-flex rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white hover:bg-orange-600">
                            Cari Katering
                        </a>
                    </div>
                @endforelse

            </section>

            {{-- RINGKASAN PESANAN --}}
            <aside class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-6">

                <h2 class="text-lg font-bold text-gray-900">
                    Ringkasan Pesanan
                </h2>

                <div class="mt-6 space-y-4 text-sm">

                    <div class="flex justify-between gap-3 text-gray-600">
                        <span>Total menu</span>

                        <span class="font-medium text-gray-900">
                            Rp{{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="border-t border-dashed border-gray-200 pt-4">
                        <div class="flex justify-between gap-3">
                            <span class="font-bold text-gray-900">
                                Total pembayaran
                            </span>

                            <span class="text-lg font-extrabold text-orange-600">
                                Rp{{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 rounded-xl bg-orange-50 p-4">
                    <p class="text-sm font-semibold text-gray-800">
                        Catatan
                    </p>

                    <p class="mt-1 text-xs leading-5 text-gray-600">
                        Pastikan menu dan jumlah pesanan sudah sesuai sebelum checkout.
                        Setiap merchant akan mendapatkan pesanan tersendiri.
                    </p>
                </div>


                <form action="{{ route('home.checkout') }}" method="GET">
                    <button type="submit" @disabled($carts->isEmpty())
                        class="mt-6 w-full rounded-xl bg-orange-500 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-50">
                        Lanjut Checkout →
                    </button>
                </form>


                <p class="mt-3 text-center text-xs text-gray-400">
                    Pesanan akan dilanjutkan ke halaman checkout.
                </p>

            </aside>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.quantity-form');
                const input = form.querySelector('input[name="qty"]');

                let quantity = Number(input.value);

                if (this.dataset.action === 'increase') {
                    quantity++;
                } else if (quantity > 1) {
                    quantity--;
                } else {
                    return;
                }

                input.value = quantity;
                form.submit();
            });
        });

        const checkoutBtn = document.getElementById('checkoutBtn');

        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', function() {
                alert('Halaman checkout akan dibuat selanjutnya.');
            });
        }
    </script>
@endpush

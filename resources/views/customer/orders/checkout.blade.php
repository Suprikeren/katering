@extends('layouts.customer.app')

@section('title', 'Checkout Pesanan')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('home.cart') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-orange-600">
                ← Kembali ke Keranjang
            </a>

            <h1 class="mt-4 text-3xl font-extrabold text-gray-900">
                Checkout Pesanan
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Lengkapi detail pengiriman sebelum membuat pesanan.
            </p>
        </div>

        {{-- Error Validation --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-bold">Periksa kembali data kamu:</p>

                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('home.checkout.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                {{-- Form Pengiriman --}}
                <div class="space-y-6 lg:col-span-2">

                    {{-- Data Customer --}}
                    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900">
                            Informasi Penerima
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Data diambil dari profil customer kamu.
                        </p>

                        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Nama Customer
                                </label>

                                <input
                                    type="text"
                                    value="{{ $customer->company_name }}"
                                    readonly
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-600"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Nomor Telepon
                                </label>

                                <input
                                    type="text"
                                    value="{{ $customer->phone }}"
                                    readonly
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-600"
                                >
                            </div>
                        </div>
                    </section>

                    {{-- Jadwal Pengiriman --}}
                    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900">
                            Jadwal Pengiriman
                        </h2>

                        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div>
                                <label for="delivery_date"
                                    class="mb-2 block text-sm font-semibold text-gray-700">
                                    Tanggal Pengiriman *
                                </label>

                                <input
                                    type="date"
                                    id="delivery_date"
                                    name="delivery_date"
                                    min="{{ now()->toDateString() }}"
                                    value="{{ old('delivery_date') }}"
                                    required
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                                >
                            </div>

                            <div>
                                <label for="delivery_time"
                                    class="mb-2 block text-sm font-semibold text-gray-700">
                                    Jam Pengiriman *
                                </label>

                                <input
                                    type="time"
                                    id="delivery_time"
                                    name="delivery_time"
                                    value="{{ old('delivery_time') }}"
                                    required
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                                >
                            </div>
                        </div>

                        <p class="mt-3 text-xs leading-5 text-gray-500">
                            Pilih jadwal ketika pesanan perlu diterima.
                            Pastikan jadwal sesuai dengan kebutuhan acara kamu.
                        </p>
                    </section>

                    {{-- Alamat --}}
                    <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900">
                            Alamat Pengiriman
                        </h2>

                        <div class="mt-5">
                            <label for="delivery_address"
                                class="mb-2 block text-sm font-semibold text-gray-700">
                                Alamat Lengkap *
                            </label>

                            <textarea
                                id="delivery_address"
                                name="delivery_address"
                                rows="4"
                                required
                                placeholder="Masukkan alamat lengkap pengiriman..."
                                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                            >{{ old('delivery_address', $customer->address) }}</textarea>
                        </div>

                        <div class="mt-5">
                            <label for="notes"
                                class="mb-2 block text-sm font-semibold text-gray-700">
                                Catatan Pesanan
                                <span class="font-normal text-gray-400">(Opsional)</span>
                            </label>

                            <textarea
                                id="notes"
                                name="notes"
                                rows="3"
                                placeholder="Contoh: nasi kotak untuk acara kantor..."
                                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-100"
                            >{{ old('notes') }}</textarea>
                        </div>
                    </section>

                </div>

                {{-- Ringkasan Pesanan --}}
                <aside class="h-fit rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900">
                        Ringkasan Pesanan
                    </h2>

                    <div class="mt-5 space-y-4">
                        @foreach ($carts as $item)
                            <div class="flex justify-between gap-4 text-sm">
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800">
                                        {{ $item->menu?->name ?? 'Menu tidak tersedia' }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $item->menu?->merchant?->company_name ?? 'Merchant' }}
                                        · {{ $item->qty }} porsi
                                    </p>
                                </div>

                                <p class="shrink-0 font-semibold text-gray-900">
                                    Rp{{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 border-t border-dashed border-gray-200 pt-5">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Total porsi</span>
                            <span>{{ $totalQuantity }}</span>
                        </div>

                        <div class="mt-3 flex justify-between gap-3">
                            <span class="font-bold text-gray-900">
                                Total Pembayaran
                            </span>

                            <span class="text-lg font-extrabold text-orange-600">
                                Rp{{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-5 rounded-xl bg-orange-50 p-4">
                        <p class="text-sm font-semibold text-gray-800">
                            Informasi
                        </p>

                        <p class="mt-1 text-xs leading-5 text-gray-600">
                            Pesanan dari merchant yang berbeda akan dibuat
                            sebagai order terpisah. Invoice dibuat untuk
                            setiap order.
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="mt-6 w-full rounded-xl bg-orange-500 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-orange-600"
                    >
                        Buat Pesanan →
                    </button>

                    <p class="mt-3 text-center text-xs leading-5 text-gray-400">
                        Periksa kembali jadwal dan alamat sebelum mengirim pesanan.
                    </p>
                </aside>

            </div>
        </form>

    </div>
</div>
@endsection


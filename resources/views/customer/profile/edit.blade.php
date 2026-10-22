
@extends('layouts.customer.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-wider text-orange-600">
                AKUN ANDA
            </p>

            <h1 class="mt-2 text-3xl font-extrabold text-gray-900">
                Profil Saya
            </h1>

            <p class="mt-2 text-sm leading-6 text-gray-500">
                Kelola informasi akun dan data diri Anda agar proses pemesanan katering lebih mudah.
            </p>
        </div>

        <form
            action="{{ route('home.profile.update') }}"
            method="POST"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            {{-- KARTU IDENTITAS --}}
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                {{-- HEADER KARTU --}}
                <div class="border-b border-gray-100 bg-gradient-to-r from-orange-50 to-white px-5 py-6 sm:px-7">
                    <div class="flex items-center gap-4">

                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-orange-100 text-2xl font-extrabold uppercase text-orange-600">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>

                        <div class="min-w-0">
                            <h2 class="break-words text-lg font-bold text-gray-900">
                                {{ auth()->user()->name }}
                            </h2>

                            <p class="mt-1 break-all text-sm text-gray-500">
                                {{ auth()->user()->email }}
                            </p>

                            <span class="mt-2 inline-flex items-center rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">
                                Customer
                            </span>
                        </div>

                    </div>
                </div>

                {{-- INFORMASI AKUN --}}
                <div class="p-5 sm:p-7">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-900">
                            Informasi Akun
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Informasi akun yang digunakan untuk masuk ke aplikasi.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- NAMA --}}
                        <div>
                            <label for="name" class="mb-2 block text-sm font-semibold text-gray-700">
                                Nama Lengkap
                            </label>

                            <input
                                id="name"
                                type="text"
                                value="{{ auth()->user()->name }}"
                                disabled
                                class="h-12 w-full cursor-not-allowed rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm text-gray-500"
                            >

                            <p class="mt-2 text-xs text-gray-400">
                                Nama akun belum dapat diubah di sini.
                            </p>
                        </div>

                        {{-- EMAIL --}}
                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">
                                Alamat Email
                            </label>

                            <input
                                id="email"
                                type="email"
                                value="{{ auth()->user()->email }}"
                                disabled
                                class="h-12 w-full cursor-not-allowed rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm text-gray-500"
                            >

                            <p class="mt-2 text-xs text-gray-400">
                                Email akun Anda saat ini.
                            </p>
                        </div>

                    </div>
                </div>
            </div>

            {{-- KARTU DATA CUSTOMER --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-7">

                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-900">
                        Informasi Pribadi
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-gray-500">
                        Lengkapi informasi berikut untuk memudahkan komunikasi dan pengiriman pesanan.
                    </p>
                </div>

                <div class="space-y-5">

                    {{-- NAMA PERUSAHAAN --}}
                    <div>
                        <label for="company_name" class="mb-2 block text-sm font-semibold text-gray-700">
                            Nama Perusahaan
                            <span class="font-normal text-gray-400">(Opsional)</span>
                        </label>

                        <input
                            id="company_name"
                            name="company_name"
                            type="text"
                            value="{{ old('company_name', $customer->company_name) }}"
                            placeholder="Contoh: PT Sejahtera atau nama instansi"
                            class="h-12 w-full rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                        >

                        @error('company_name')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NOMOR TELEPON --}}
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-semibold text-gray-700">
                            Nomor Telepon
                        </label>

                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            value="{{ old('phone', $customer->phone) }}"
                            placeholder="Contoh: 081234567890"
                            class="h-12 w-full rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                        >

                        @error('phone')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ALAMAT --}}
                    <div>
                        <label for="address" class="mb-2 block text-sm font-semibold text-gray-700">
                            Alamat Lengkap
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="4"
                            placeholder="Masukkan alamat lengkap untuk keperluan pengiriman pesanan."
                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm leading-6 text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                        >{{ old('address', $customer->address) }}</textarea>

                        @error('address')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- TOMBOL --}}
                <div class="mt-7 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">

                    <button
                        type="reset"
                        class="inline-flex h-12 items-center justify-center rounded-xl border border-gray-200 px-5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
                    >
                        Reset Form
                    </button>

                    <button
                        type="submit"
                        class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-orange-500 px-6 text-sm font-bold text-white shadow-sm transition hover:bg-orange-600 focus:outline-none focus:ring-4 focus:ring-orange-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        Simpan Perubahan
                    </button>

                </div>
            </div>

        </form>

        {{-- INFORMASI TAMBAHAN --}}
        <div class="flex gap-3 rounded-2xl border border-orange-100 bg-orange-50 p-4">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="mt-0.5 h-5 w-5 shrink-0 text-orange-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m0 3h.008M10.29 3.86L1.82 18.14A2 2 0 003.53 21h16.94a2 2 0 001.71-2.86L13.71 3.86a2 2 0 00-3.42 0z"
                />
            </svg>

            <div>
                <p class="text-sm font-semibold text-gray-800">
                    Pastikan data Anda benar
                </p>

                <p class="mt-1 text-xs leading-5 text-gray-600">
                    Nomor telepon dan alamat yang benar membantu Pihak catering menghubungi Anda serta memproses pesanan dengan lebih lancar.
                </p>
            </div>
        </div>

    </div>
@endsection

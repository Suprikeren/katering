@extends('layouts.customer.app')

@section('title', 'Beranda')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- HERO --}}
        <section
            class="grid overflow-hidden rounded-3xl bg-gradient-to-br from-orange-50 via-orange-50 to-green-50 md:grid-cols-2">
            <div class="flex flex-col justify-center p-6 sm:p-10 lg:p-14">
                <span
                    class="w-fit rounded-full border border-orange-200 bg-white px-4 py-2 text-xs font-semibold text-orange-700">
                    🍃 Praktis, Lezat, Terpercaya
                </span>

                <h1 class="mt-6 text-4xl font-extrabold leading-tight tracking-tight text-gray-900 sm:text-5xl">
                    Pesan Katering
                    <span class="block text-green-700">Favorit Anda</span>
                </h1>

                <p class="mt-5 max-w-lg leading-7 text-gray-600">
                    Temukan katering berkualitas untuk acara keluarga, rapat kantor,
                    hingga kebutuhan makan harian Anda.
                </p>

                <form id="homeSearch" class="mt-7 flex flex-col gap-2 rounded-2xl bg-white p-2 shadow-lg sm:flex-row">
                    <input id="searchInput" type="text" placeholder="Cari nama katering atau menu..."
                        class="min-w-0 flex-1 rounded-xl px-3 py-3 text-sm outline-none">

                    <button
                        class="rounded-xl bg-orange-500 px-5 py-3 font-semibold text-white transition hover:bg-orange-600">
                        Cari Katering
                    </button>
                </form>

                <div class="mt-5 flex flex-wrap gap-4 text-xs font-medium text-gray-600">
                    <span>✓ Banyak pilihan menu</span>
                    <span>✓ Praktis dan mudah</span>
                </div>
            </div>

            <div class="relative min-h-64 p-4 sm:min-h-96">
                <img src="https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=1000&q=85"
                    alt="Hidangan katering" class="h-full min-h-64 w-full rounded-2xl object-cover sm:min-h-96">

                <div class="absolute bottom-8 right-7 flex items-center gap-3 rounded-2xl bg-white/95 p-4 shadow-lg">
                    <span class="text-3xl">🍱</span>
                    <div>
                        <p class="font-bold text-gray-900">Menu pilihan</p>
                        <p class="text-xs text-gray-500">Untuk momen spesial</p>
                    </div>
                </div>
            </div>
        </section>


        {{-- REKOMENDASI --}}
        <section class="mt-12">
            <div class="mb-5 flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-bold tracking-[0.2em] text-orange-600">REKOMENDASI</p>
                    <h2 class="mt-2 text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                        Katering Pilihan untuk Anda
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Temukan menu favorit untuk setiap kebutuhan.
                    </p>
                </div>

                <a href="{{ route('home.caterings') }}" class="shrink-0 text-sm font-semibold text-orange-600 hover:text-orange-700">
                    Jelajahi semua →
                </a>
            </div>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($merchant as $catering)
                    <article
                        class="overflow-hidden rounded-2xl border border-gray-100 bg-white transition hover:-translate-y-1 hover:shadow-xl">

                        <div class="relative h-52 overflow-hidden">
                            <img  src="{{ asset('storage/' . $catering->thumbnail) }}" alt="{{ $catering->company_name }}"
                                loading="lazy" class="h-full w-full object-cover transition duration-300 hover:scale-105">

                            <span
                                class="absolute left-3 top-3 rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-gray-800 shadow">
                                {{ $catering->food_type ?? 'Katering' }}
                            </span>

                            <button type="button"
                                class="favorite-btn absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white text-xl text-gray-700 shadow hover:text-red-500"
                                aria-label="Favorit">
                                ♡
                            </button>
                        </div>

                        <div class="p-5">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-lg font-bold text-gray-900">
                                    {{ $catering->company_name ?? 'Nama Katering' }}
                                </h3>
                            </div>

                            <p class="mt-2 text-sm text-gray-500">
                                📍 {{ $catering->address ?? 'Alamat belum tersedia' }}
                            </p>

                            <p class="mt-3 min-h-10 text-sm leading-6 text-gray-600">
                                {{ $catering->description ?? 'Belum ada deskripsi katering.' }}
                            </p>

                            <div
                                class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4 text-xs text-gray-500">
                                <span>🍽️ {{ $catering->food_type ?? 'Berbagai Menu' }}</span>
                                <span>Menu katering</span>
                            </div>

                            <div class="mt-4 flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-xs text-gray-500">Informasi</p>
                                    <p class="font-bold text-gray-900">
                                        {{ $catering->phone ?? 'Kontak belum tersedia' }}
                                    </p>
                                </div>

                                <a href="{{ route('home.detail-catering',$catering->id) }}"
                                    class="rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600">
                                    Lihat Menu
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        {{-- BANNER --}}
        <section
            class="mt-12 flex items-center justify-between gap-5 overflow-hidden rounded-3xl border border-green-100 bg-gradient-to-r from-green-50 to-emerald-100 p-6 sm:p-10">
            <div class="max-w-2xl">
                <p class="text-xs font-bold tracking-[0.2em] text-green-700">
                    UNTUK MOMEN SPESIAL
                </p>

                <h2 class="mt-3 text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                    Ada acara yang ingin dirayakan?
                </h2>

                <p class="mt-3 max-w-xl text-sm leading-7 text-gray-600">
                    Dari rapat kantor hingga acara keluarga, temukan katering
                    yang sesuai dengan kebutuhan dan anggaran Anda.
                </p>

                <a href="#"
                    class="mt-5 inline-flex rounded-xl bg-green-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-800">
                    Temukan Katering →
                </a>
            </div>

            <div
                class="hidden shrink-0 items-center justify-center rounded-full bg-white/70 text-6xl sm:flex sm:h-32 sm:w-32 lg:text-7xl">
                🍽️
            </div>
        </section>

        {{-- AJAKAN MERCHANT BERGABUNG --}}
        <section class="mt-12 overflow-hidden rounded-3xl bg-gray-900 p-6 sm:p-10 lg:p-12">
            <div class="flex flex-col items-center justify-between gap-8 sm:flex-row">
                <div class="max-w-2xl">
                    <span class="rounded-full bg-green-500/20 px-3 py-1.5 text-xs font-semibold text-green-400">
                        UNTUK PEMILIK USAHA KATERING
                    </span>

                    <h2 class="mt-5 text-2xl font-extrabold leading-tight text-white sm:text-3xl">
                        Punya Usaha Katering?
                        <span class="text-orange-400">Yuk, Bergabung!</span>
                    </h2>

                    <p class="mt-4 text-sm leading-7 text-gray-300 sm:text-base">
                        Daftarkan usaha katering Anda di KateringKu, tampilkan menu
                        andalan, dan jangkau lebih banyak pelanggan dengan lebih mudah.
                    </p>

                    <a href="#"
                        class="mt-6 inline-flex items-center gap-2 rounded-xl bg-orange-500 px-5 py-3 font-semibold text-white transition hover:bg-orange-600">
                        Daftarkan Katering Anda
                        <span>→</span>
                    </a>
                </div>

                <div
                    class="flex h-36 w-36 shrink-0 items-center justify-center rounded-full bg-white/10 text-7xl sm:h-44 sm:w-44">
                    🧑‍🍳
                </div>
            </div>
        </section>

    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('homeSearch').addEventListener('submit', function(event) {
            event.preventDefault();

            const keyword = document.getElementById('searchInput').value.trim();

            if (keyword === '') {
                alert('Masukkan nama katering atau menu yang ingin dicari.');
                return;
            }

            alert('Pencarian "' + keyword + '" akan dihubungkan ke daftar katering nanti.');
        });

        document.querySelectorAll('.favorite-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const active = this.classList.toggle('text-red-500');
                this.textContent = active ? '♥' : '♡';
            });
        });
    </script>
@endpush

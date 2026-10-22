@extends('layouts.customer.app')

@section('title', 'Jelajahi Katering')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="rounded-3xl bg-gradient-to-r from-orange-50 to-green-50 p-6 sm:p-10">
            <span class="text-sm font-semibold tracking-wider text-orange-600">
                KATERING UNTUK SETIAP MOMEN
            </span>

            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Temukan Katering Favoritmu
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-7 text-gray-600 sm:text-base">
                Jelajahi berbagai pilihan katering, lihat menu yang tersedia,
                dan temukan hidangan yang cocok untuk kebutuhanmu.
            </p>

            {{-- SEARCH --}}
            <form method="GET" action="{{ url()->current() }}"
                class="mt-6 flex flex-col gap-3 rounded-2xl bg-white p-3 shadow-sm sm:flex-row">

                <div class="flex flex-1 items-center gap-3 px-3">
                    <span class="text-xl">🔍</span>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama katering..."
                        class="w-full py-3 text-sm outline-none"
                    >
                </div>

                <select
                    name="location"
                    class="rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none"
                >
                    <option value="">Semua Lokasi</option>

                    @foreach ($locations as $location)
                        <option value="{{ $location }}" @selected(request('location') === $location)>
                            {{ $location }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="rounded-xl bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                >
                    Cari Katering
                </button>
            </form>
        </div>

        {{-- DAFTAR KATERING --}}
        <section class="mt-10">
            <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900">
                        Daftar Katering
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Pilihan katering untuk berbagai kebutuhan.
                    </p>
                </div>

                <span class="text-sm text-gray-500">
                    {{ $merchant->count() }} katering ditemukan
                </span>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($merchant as $catering)
                    <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                        {{-- GAMBAR --}}
                        <div class="relative h-56 overflow-hidden bg-gray-100 sm:h-60">
                            <img
                                src="https://placehold.co/800x500?text=Katering"
                                alt="{{ $catering->company_name }}"
                                loading="lazy"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            >

                            <span class="absolute left-4 top-4 rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-orange-700 shadow-sm">
                                {{ $catering->food_type ?? 'Katering' }}
                            </span>
                        </div>

                        {{-- INFORMASI --}}
                        <div class="p-5 sm:p-6">
                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $catering->company_name ?? 'Nama Katering' }}
                            </h3>

                            <p class="mt-3 flex items-start gap-2 text-sm leading-6 text-gray-500">
                                <span>📍</span>
                                <span>{{ $catering->address ?? 'Alamat belum tersedia' }}</span>
                            </p>

                            <p class="mt-3 min-h-12 text-sm leading-6 text-gray-600">
                                {{ $catering->description ?? 'Belum ada deskripsi katering.' }}
                            </p>

                            <div class="mt-5 flex items-center justify-between gap-3 border-t border-gray-100 pt-5">
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-400">
                                        Kontak
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-gray-800">
                                        {{ $catering->phone ?? 'Belum tersedia' }}
                                    </p>
                                </div>

                                <a
                                    href="{{ route('home.detail-catering', $catering->id) }}"
                                    class="shrink-0 rounded-xl bg-orange-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                                >
                                    Lihat Menu →
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center">
                        <div class="text-4xl">🍽️</div>

                        <h3 class="mt-4 text-lg font-bold text-gray-900">
                            Katering tidak ditemukan
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Belum ada katering yang tersedia saat ini.
                        </p>

                        <a
                            href="{{ url()->current() }}"
                            class="mt-5 inline-flex rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white hover:bg-orange-600"
                        >
                            Lihat Semua Katering
                        </a>
                    </div>
                @endforelse
            </div>


        </section>

          <div class="mt-8">
            {{ $merchant->links() }}
        </div>

    </div>
@endsection


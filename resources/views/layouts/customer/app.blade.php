<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f97316">

    <title>@yield('title', 'KateringKu') - KateringKu</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            DEFAULT: '#f97316',
                            dark: '#ea580c',
                        },
                        forest: '#15803d',
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>

<body class="flex min-h-screen flex-col bg-gray-50 text-gray-800 antialiased">

    @php
        $navLink = 'rounded-xl px-3 py-2.5 text-sm font-semibold transition duration-200';
        $activeLink = 'bg-orange-50 text-orange-600';
        $inactiveLink = 'text-gray-600 hover:bg-orange-50 hover:text-orange-600';
    @endphp

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-50 border-b border-gray-100 bg-white/95 backdrop-blur">
        <div class="mx-auto flex min-h-16 max-w-7xl items-center justify-between gap-3 px-4 sm:px-6 lg:min-h-[72px] lg:px-8">

            {{-- LOGO --}}
            <a href="{{ route('home.index') }}" class="flex shrink-0 items-center gap-2">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-100 text-xl">
                    🍱
                </span>

                <span class="text-xl font-extrabold tracking-tight text-gray-900">
                    Katering<span class="text-orange-500">Ku</span>
                </span>
            </a>

            {{-- NAVIGASI DESKTOP --}}
            <nav class="hidden items-center gap-1 md:flex">

                <a href="{{ route('home.index') }}"
                   class="{{ $navLink }} {{ request()->routeIs('home.index') ? $activeLink : $inactiveLink }}">
                    Beranda
                </a>

                <a href="{{ route('home.caterings') }}"
                   class="{{ $navLink }} {{ request()->routeIs('home.caterings', 'home.detail-catering') ? $activeLink : $inactiveLink }}">
                    Catering
                </a>

                <a href="{{ route('home.cart') }}"
                   class="{{ $navLink }} {{ request()->routeIs('home.cart', 'home.cart.*') ? $activeLink : $inactiveLink }}">
                    Keranjang
                </a>

                <a href="{{ route('home.invoices') }}"
                   class="{{ $navLink }} {{ request()->routeIs('home.invoices', 'home.invoices.*') ? $activeLink : $inactiveLink }}">
                    Pesanan Saya
                </a>

                @auth
                    <a href="{{ route('home.profile.edit') }}"
                       class="{{ $navLink }} {{ request()->routeIs('home.profile.*') ? $activeLink : $inactiveLink }}">
                        Profil Saya
                    </a>
                @endauth

            </nav>

            {{-- AKSI NAVBAR --}}
            <div class="flex shrink-0 items-center gap-2">

                {{-- KERANJANG --}}
                <a href="{{ route('home.cart') }}"
                   aria-label="Keranjang"
                   class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 text-lg transition hover:border-orange-200 hover:bg-orange-50">

                    🛒

                    <span id="cart-count"
                          class="absolute -right-1.5 -top-1.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-orange-500 px-1 text-[10px] font-bold text-white">
                        0
                    </span>
                </a>

                {{-- PROFIL DAN LOGIN / LOGOUT DESKTOP --}}
                @auth
                    <a href="{{ route('home.profile.edit') }}"
                       aria-label="Profil Saya"
                       class="hidden h-10 w-10 items-center justify-center rounded-xl border border-orange-200 bg-orange-50 text-lg text-orange-600 transition hover:bg-orange-100 sm:flex md:hidden lg:flex">
                        👤
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="hidden sm:block">
                        @csrf

                        <button type="submit"
                                class="rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600 sm:inline-flex">
                        Login
                    </a>
                @endauth

                {{-- TOMBOL MENU MOBILE --}}
                <button type="button"
                        id="mobileMenu"
                        aria-label="Buka menu"
                        aria-expanded="false"
                        aria-controls="mobileNav"
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 text-xl transition hover:bg-gray-50 md:hidden">
                    ☰
                </button>

            </div>
        </div>

        {{-- NAVIGASI MOBILE --}}
        <nav id="mobileNav" class="hidden border-t border-gray-100 bg-white px-4 py-3 md:hidden">
            <div class="mx-auto flex max-w-7xl flex-col gap-1">

                <a href="{{ route('home.index') }}"
                   class="{{ $navLink }} {{ request()->routeIs('home.index') ? $activeLink : $inactiveLink }}">
                    Beranda
                </a>

                <a href="{{ route('home.caterings') }}"
                   class="{{ $navLink }} {{ request()->routeIs('home.caterings', 'home.detail-catering') ? $activeLink : $inactiveLink }}">
                    Catering
                </a>

                <a href="{{ route('home.cart') }}"
                   class="{{ $navLink }} {{ request()->routeIs('home.cart', 'home.cart.*') ? $activeLink : $inactiveLink }}">
                    Keranjang
                </a>

                <a href="{{ route('home.invoices') }}"
                   class="{{ $navLink }} {{ request()->routeIs('home.invoices', 'home.invoices.*') ? $activeLink : $inactiveLink }}">
                    Pesanan Saya
                </a>

                @auth
                    <a href="{{ route('home.profile.edit') }}"
                       class="{{ $navLink }} {{ request()->routeIs('home.profile.*') ? $activeLink : $inactiveLink }}">
                        👤 Profil Saya
                    </a>
                @endauth

                <div class="my-2 border-t border-gray-100"></div>

                {{-- LOGIN / LOGOUT MOBILE --}}
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                                class="w-full rounded-xl px-3 py-3 text-left text-sm font-semibold text-red-600 transition hover:bg-red-50">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="{{ $navLink }} block {{ request()->routeIs('login') ? $activeLink : $inactiveLink }}">
                        Login
                    </a>
                @endauth

            </div>
        </nav>
    </header>

    {{-- PESAN SUKSES / ERROR --}}
    @if (session('success') || session('error'))
        <div class="mx-auto mt-4 w-full max-w-7xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @endif

    {{-- KONTEN HALAMAN --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="mt-12 border-t border-gray-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-8 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">

            <a href="{{ route('home.index') }}" class="flex items-center gap-2">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-100 text-lg">
                    🍱
                </span>

                <span class="text-lg font-extrabold text-gray-900">
                    Katering<span class="text-orange-500">Ku</span>
                </span>
            </a>

            <p class="text-sm text-gray-500">
                Solusi katering untuk setiap momen spesial.
            </p>

            <p class="text-sm text-gray-400">
                © {{ date('Y') }} KateringKu
            </p>

        </div>
    </footer>

    {{-- JAVASCRIPT --}}
    <script>
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileNav = document.getElementById('mobileNav');

        mobileMenu.addEventListener('click', function () {
            mobileNav.classList.toggle('hidden');

            const isOpen = !mobileNav.classList.contains('hidden');

            mobileMenu.setAttribute('aria-expanded', isOpen);
            mobileMenu.setAttribute(
                'aria-label',
                isOpen ? 'Tutup menu' : 'Buka menu'
            );

            mobileMenu.textContent = isOpen ? '✕' : '☰';
        });
    </script>

    @stack('scripts')

</body>
</html>

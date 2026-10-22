@php
    $activePage = 'dashboard';

     $activePage = request()->routeIs('dashboard.super-admin.merchants.*')
        ? 'merchants'
        : (request()->routeIs('dashboard.index') ? 'dashboard' : '');
    if (request()->routeIs('dashboard.merchant.menus.*')) {
        $activePage = 'menus';
    } elseif (request()->routeIs('dashboard.merchant.orders.*')) {
        $activePage = 'orders';
    } elseif (request()->routeIs('dashboard.merchant.invoices.*')) {
        $activePage = 'invoices';
    } elseif (request()->routeIs('dashboard.users.*')) {
        $activePage = 'users';
    } elseif (request()->routeIs('dashboard.roles.*')) {
        $activePage = 'roles';
    } elseif (request()->routeIs('dashboard.permissions.*')) {
        $activePage = 'permissions';
    }

    $openSection = in_array($activePage, ['menus', 'orders', 'invoices'], true)
        ? 'Operasional'
        : (in_array($activePage, ['users', 'roles', 'permissions'], true)
            ? 'HakAkses'
            : '');
@endphp

<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0">
    {{-- SIDEBAR HEADER --}}
    <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="sidebar-header flex items-center gap-2 pb-7 pt-8">
        <a href="{{ route('dashboard.index') }}">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                <img class="dark:hidden" src="{{ asset('assets/admin/images/logo/logo.svg') }}" alt="Logo">
                <img class="hidden dark:block" src="{{ asset('assets/admin/images/logo/logo-dark.svg') }}" alt="Logo">
            </span>

            <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'"
                src="{{ asset('assets/admin/images/logo/logo-icon.svg') }}" alt="Logo">
        </a>
    </div>

    <div class="no-scrollbar flex min-h-0 flex-1 flex-col overflow-y-auto duration-300 ease-linear">
        <nav x-data="{ selected: '{{ $openSection }}' }">
            <div>
                <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                    <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                        MENU
                    </span>

                    <span class="menu-group-icon mx-auto hidden text-center"
                        :class="sidebarToggle ? 'lg:block' : 'hidden'">
                        •••
                    </span>
                </h3>

                <ul class="mb-6 flex flex-col gap-4">

                    {{-- DASHBOARD --}}
                    <li>
                        <a href="{{ route('dashboard.index') }}"
                            class="menu-item group {{ $activePage === 'dashboard' ? 'menu-item-active' : 'menu-item-inactive' }}">
                            <svg class="{{ $activePage === 'dashboard' ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 13h8V3H3v10Zm0 8h8v-6H3v6Zm10 0h8V11h-8v10Zm0-18v6h8V3h-8Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>

                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    @if (auth()->user()->hasRole('super-admin'))
                        <li>
                            <a href="{{ route('dashboard.super-admin.merchants.index') }}"
                                class="menu-item group {{ $activePage === 'merchants' ? 'menu-item-active' : 'menu-item-inactive' }}">

                                <svg class="{{ $activePage === 'merchants' ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 13h8V3H3v10Zm0 8h8v-6H3v6Zm10 0h8V11h-8v10Zm0-18v6h8V3h-8Z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                </svg>

                                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                    Catering
                                </span>
                            </a>
                        </li>
                    @endif

                    {{-- OPERASIONAL --}}
                    @if (auth()->user()->hasRole('merchant'))
                        <li>
                            <button type="button" @click="selected = selected === 'Operasional' ? '' : 'Operasional'"
                                class="menu-item group w-full {{ in_array($activePage, ['menus', 'orders', 'invoices'], true) ? 'menu-item-active' : 'menu-item-inactive' }}">
                                <svg class="{{ in_array($activePage, ['menus', 'orders', 'invoices'], true) ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 4h16v16H4zM8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                    Operasional
                                </span>

                                <svg class="menu-item-arrow"
                                    :class="[
                                        selected === 'Operasional' ?
                                        'menu-item-arrow-active' :
                                        'menu-item-arrow-inactive',
                                        sidebarToggle ? 'lg:hidden' : ''
                                    ]"
                                    width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="m5 7.5 5 5 5-5" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>

                            <div class="overflow-hidden" :class="selected === 'Operasional' ? 'block' : 'hidden'">
                                <ul class="menu-dropdown mt-2 flex flex-col gap-1 pl-9"
                                    :class="sidebarToggle ? 'lg:hidden' : ''">
                                    <li>
                                        <a href="{{ route('dashboard.merchant.menus.index') }}"
                                            class="menu-dropdown-item group {{ $activePage === 'menus' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                            Menu
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.merchant.orders.index') }}"
                                            class="menu-dropdown-item group {{ $activePage === 'orders' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                            Orders
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('dashboard.merchant.invoices.index') }}"
                                            class="menu-dropdown-item group {{ $activePage === 'invoices' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                            Invoices
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </div>

    {{-- HAK AKSES --}}
    @if (auth()->user()->hasRole('super-admin'))
        <nav x-data="{ selected: '{{ $openSection === 'HakAkses' ? 'HakAkses' : '' }}' }" class="border-t border-gray-200 dark:border-gray-800">
            <div class="py-4">
                <button type="button" @click="selected = selected === 'HakAkses' ? '' : 'HakAkses'"
                    class="menu-item group w-full {{ in_array($activePage, ['users', 'roles', 'permissions'], true) ? 'menu-item-active' : 'menu-item-inactive' }}">
                    <svg class="{{ in_array($activePage, ['users', 'roles', 'permissions'], true) ? 'menu-item-icon-active' : 'menu-item-icon-inactive' }}"
                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8ZM4 20v-2a6 6 0 0 1 12 0v2H4Zm13-9a3 3 0 1 0 0-6m1 9a5 5 0 0 1 2 4v2"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                        Hak Akses
                    </span>

                    <svg class="menu-item-arrow"
                        :class="[
                            selected === 'HakAkses' ?
                            'menu-item-arrow-active' :
                            'menu-item-arrow-inactive',
                            sidebarToggle ? 'lg:hidden' : ''
                        ]"
                        width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="m5 7.5 5 5 5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>

                <div class="overflow-hidden" :class="selected === 'HakAkses' ? 'block' : 'hidden'">
                    <ul class="menu-dropdown mt-2 flex flex-col gap-1 pl-9" :class="sidebarToggle ? 'lg:hidden' : ''">
                        <li>
                            <a href="{{ route('dashboard.users.index') }}"
                                class="menu-dropdown-item group {{ $activePage === 'users' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                Users
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('dashboard.roles.index') }}"
                                class="menu-dropdown-item group {{ $activePage === 'roles' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                Roles
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('dashboard.permissions.index') }}"
                                class="menu-dropdown-item group {{ $activePage === 'permissions' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                                Permissions
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endif
</aside>

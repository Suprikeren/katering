@extends('layouts.admins.app')

@section('content')
    @include('dashboard.partials.header', [
        'title' => 'Merchants',
        'subtitle' => 'Pantau data merchant yang terdaftar',
    ])

    <div class="col-span-12">
        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">

            {{-- Toolbar --}}
            <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">

                <form
                    method="GET"
                    action="{{ route('dashboard.super-admin.merchants.index') }}"
                    class="flex flex-wrap items-center gap-2"
                >
                    <div class="relative">
                        <svg
                            class="absolute top-1/2 left-3.5 -translate-y-1/2 fill-gray-400"
                            width="16"
                            height="16"
                            viewBox="0 0 16 16"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M7.16675 2.75C4.72752 2.75 2.75008 4.72744 2.75008 7.16667C2.75008 9.6059 4.72752 11.5833 7.16675 11.5833C8.30958 11.5833 9.35439 11.1726 10.1797 10.4789L12.1005 12.3997C12.3956 12.6947 12.8704 12.6947 13.1655 12.3997C13.4605 12.1046 13.4605 11.6297 13.1655 11.3346L11.2447 9.41388C11.9384 8.58858 12.3491 7.54377 12.3491 6.40094C12.3491 4.96169 11.2257 3.71283 9.83968 3.61973C9.59268 2.75028 8.78832 2.16667 7.86083 2.16667H7.16675V2.75ZM7.16675 4.25C5.55592 4.25 4.25008 5.55584 4.25008 7.16667C4.25008 8.7775 5.55592 10.0833 7.16675 10.0833C8.77758 10.0833 10.0834 8.7775 10.0834 7.16667C10.0834 5.55584 8.77758 4.25 7.16675 4.25Z"
                            />
                        </svg>

                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama merchant..."
                            class="h-10 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-4 pl-9 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 dark:border-gray-800 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30 sm:w-64"
                        >
                    </div>

                    <button
                        type="submit"
                        class="rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        Cari
                    </button>

                    @if (request('search') != null && request('search') != '')
                        <a
                            href="{{ route('dashboard.super-admin.merchants.index') }}"
                            class="text-theme-sm font-medium text-gray-500 transition hover:text-brand-500 dark:text-gray-400"
                        >
                            Reset
                        </a>
                    @endif
                </form>

                <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                    Menampilkan {{ $merchants->total() }} merchant
                </p>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-left">
                    <thead class="border-b border-gray-200 dark:border-gray-800">
                        <tr class="bg-gray-50 dark:bg-gray-800/40">
                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Merchant
                            </th>

                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Pemilik
                            </th>

                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Telepon
                            </th>

                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Jenis Makanan
                            </th>

                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                Status Profil
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($merchants as $merchant)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-white/5">

                                {{-- Merchant --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($merchant->icon)
                                            <img
                                                src="{{ asset('storage/' . $merchant->icon) }}"
                                                alt="{{ $merchant->company_name }}"
                                                class="h-10 w-10 rounded-lg object-cover"
                                            >
                                        @else
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 font-semibold text-brand-500 dark:bg-brand-500/15">
                                                {{ strtoupper(substr($merchant->company_name ?: 'M', 0, 1)) }}
                                            </div>
                                        @endif

                                        <div>
                                            <span class="font-medium text-gray-800 dark:text-white/90">
                                                {{ $merchant->company_name ?: 'Belum diisi' }}
                                            </span>

                                            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                                                ID: {{ $merchant->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Pemilik --}}
                                <td class="px-5 py-4">
                                    <span class="font-medium text-gray-800 dark:text-white/90">
                                        {{ $merchant->user?->name ?? '-' }}
                                    </span>

                                    <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                                        {{ $merchant->user?->email ?? '-' }}
                                    </p>
                                </td>

                                {{-- Telepon --}}
                                <td class="px-5 py-4 text-theme-sm text-gray-500 dark:text-gray-400">
                                    {{ $merchant->phone ?: '-' }}
                                </td>

                                {{-- Jenis Makanan --}}
                                <td class="px-5 py-4 text-theme-sm text-gray-500 dark:text-gray-400">
                                    {{ $merchant->food_type ?: '-' }}
                                </td>

                                {{-- Status Profil --}}
                                <td class="px-5 py-4">
                                    @if (
                                        filled($merchant->company_name) &&
                                        filled($merchant->phone) &&
                                        filled($merchant->address)
                                    )
                                        <span class="rounded-full bg-success-50 px-2.5 py-1 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-400">
                                            Lengkap
                                        </span>
                                    @else
                                        <span class="rounded-full bg-warning-50 px-2.5 py-1 text-theme-xs font-medium text-warning-600 dark:bg-warning-500/15 dark:text-warning-400">
                                            Belum Lengkap
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    @include('dashboard.partials.empty-state', [
                                        'message' => request('search')
                                            ? 'Merchant tidak ditemukan.'
                                            : 'Belum ada merchant terdaftar.',
                                    ])
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800">
                {{ $merchants->links() }}
            </div>

        </div>
    </div>
@endsection

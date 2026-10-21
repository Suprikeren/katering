@extends('layouts.admins.app')

@section('content')
    @include('dashboard.partials.header', [
        'title' => 'Roles',
        'subtitle' => 'Kelola role dan permission-nya',
        'createLabel' => 'Tambah Role',
        'createUrl' => route('dashboard.roles.create'),
    ])

    <div class="col-span-12">
        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            {{-- Toolbar --}}
            <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">
                <form method="GET" action="{{ route('dashboard.roles.index') }}" class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <svg class="absolute top-1/2 left-3.5 -translate-y-1/2 fill-gray-400" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.16675 2.75C4.72752 2.75 2.75008 4.72744 2.75008 7.16667C2.75008 9.6059 4.72752 11.5833 7.16675 11.5833C8.30958 11.5833 9.35439 11.1726 10.1797 10.4789L12.1005 12.3997C12.3956 12.6947 12.8704 12.6947 13.1655 12.3997C13.4605 12.1046 13.4605 11.6297 13.1655 11.3346L11.2447 9.41388C11.9384 8.58858 12.3491 7.54377 12.3491 6.40094C12.3491 4.96169 11.2257 3.71283 9.83968 3.61973C9.59268 2.75028 8.78832 2.16667 7.86083 2.16667H7.16675V2.75ZM7.16675 4.25C5.55592 4.25 4.25008 5.55584 4.25008 7.16667C4.25008 8.7775 5.55592 10.0833 7.16675 10.0833C8.77758 10.0833 10.0834 8.7775 10.0834 7.16667C10.0834 5.55584 8.77758 4.25 7.16675 4.25Z" fill="" />
                        </svg>
                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari role..."
                            class="h-10 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-4 pl-9 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 dark:border-gray-800 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30 sm:w-64"
                        >
                    </div>
                    <button type="submit" class="rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Cari</button>
                    @if (request()->filled('search'))
                        <a href="{{ route('dashboard.roles.index') }}" class="text-theme-sm font-medium text-gray-500 transition hover:text-brand-500 dark:text-gray-400">Reset</a>
                    @endif
                </form>

                <p class="text-theme-sm text-gray-500 dark:text-gray-400">Menampilkan {{ $roles->total() }} role</p>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-left">
                    <thead class="border-b border-gray-200 dark:border-gray-800">
                        <tr class="bg-gray-50 dark:bg-gray-800/40">
                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Role</th>
                            <th class="px-5 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">Permissions</th>
                            <th class="px-5 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">Jumlah User</th>
                            <th class="px-5 py-3 text-right text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($roles as $role)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-50 text-theme-sm font-semibold text-brand-500 uppercase dark:bg-brand-500/15 dark:text-brand-400">
                                            {{ strtoupper(substr($role->name, 0, 1)) }}
                                        </span>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="font-medium text-gray-800 dark:text-white/90">{{ $role->name }}</span>
                                            @if ($role->name === 'super-admin')
                                                <span class="rounded-full bg-orange-50 px-2.5 py-0.5 text-theme-xs font-medium text-orange-600 dark:bg-orange-500/15 dark:text-orange-400">Super Admin</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-theme-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        {{ $role->permissions_count }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-theme-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        {{ $role->users_count }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        @can('role.update')
                                            <a
                                                href="{{ route('dashboard.roles.edit', $role) }}"
                                                title="Edit"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
                                            >
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.829-2.828z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('role.delete')
                                            <form
                                                method="POST"
                                                action="{{ route('dashboard.roles.destroy', $role) }}"
                                                class="inline"
                                                data-confirm="Role '{{ $role->name }}' akan dihapus secara permanen."
                                                data-confirm-title="Hapus Role"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    title="Hapus"
                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 text-error-500 transition hover:bg-error-50 dark:border-gray-700 dark:hover:bg-error-500/10"
                                                >
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    @include('dashboard.partials.empty-state', ['message' => 'Belum ada role.'])
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection

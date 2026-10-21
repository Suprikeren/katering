@extends('layouts.admins.app')

@section('content')
    <div
        class="col-span-12"
        x-data="permissionModal(@js($modalState), '{{ route('dashboard.permissions.index') }}')"
    >
        @include('dashboard.partials.header', [
            'title' => 'Permissions',
            'subtitle' => 'Kelola daftar permission',
            'createLabel' => 'Tambah Permission',
            'createOnClick' => 'openCreate()',
        ])

        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-800">
                <p class="text-theme-sm text-gray-500 dark:text-gray-400">Menampilkan {{ $permissions->total() }} permission</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-left">
                    <thead class="border-b border-gray-200 dark:border-gray-800">
                        <tr class="bg-gray-50 dark:bg-gray-800/40">
                            <th class="px-5 py-3 text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Permission</th>
                            <th class="px-5 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">Dipakai oleh Role</th>
                            <th class="px-5 py-3 text-right text-theme-xs font-medium text-gray-500 uppercase dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($permissions as $permission)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1.5 text-theme-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>
                                        {{ $permission->name }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-theme-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        {{ $permission->roles_count }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        @can('permission.update')
                                            <button
                                                type="button"
                                                title="Edit"
                                                @click="openEdit({{ $permission->id }}, '{{ $permission->name }}')"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
                                            >
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.829-2.828z" />
                                                </svg>
                                            </button>
                                        @endcan

                                        @can('permission.delete')
                                            <form
                                                method="POST"
                                                action="{{ route('dashboard.permissions.destroy', $permission) }}"
                                                class="inline"
                                                data-confirm="Permission '{{ $permission->name }}' akan dihapus secara permanen."
                                                data-confirm-title="Hapus Permission"
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
                                <td colspan="3">
                                    @include('dashboard.partials.empty-state', ['message' => 'Belum ada permission.'])
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800">
                {{ $permissions->links() }}
            </div>
        </div>

        @include('dashboard.permissions._modal')
    </div>
@endsection

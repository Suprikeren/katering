@php
    $role = $role ?? null;
    $selectedPermissions = old('permissions', $role?->permissions->pluck('id')->all() ?? []);
@endphp

<div class="col-span-12">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $role ? 'Data Role' : 'Data Role Baru' }}</h2>
        </div>

        <div class="grid gap-6 px-6 py-5">
            {{-- Name --}}
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Role</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $role?->name) }}"
                    required
                    autofocus
                    placeholder="contoh: editor"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 @error('name') border-error-500 @enderror"
                >
                @error('name')
                    <p class="mt-1.5 text-theme-xs text-error-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Permissions --}}
            <div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permissions</label>
                    <p class="mt-1 text-theme-xs text-gray-400">Centang permission yang akan diberikan ke role ini.</p>
                </div>

                <div class="grid gap-4">
                    @forelse ($permissionGroups as $category => $permissions)
                        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
                            <div class="flex items-center justify-between border-b border-gray-100 bg-gray-50 px-4 py-3 dark:border-gray-800 dark:bg-gray-800/40">
                                <h4 class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ ucfirst($category) }}</h4>
                                <button
                                    type="button"
                                    data-check-all="#permission-group-{{ Str::slug($category) }}"
                                    class="text-theme-xs font-medium text-brand-500 transition hover:text-brand-600 dark:text-brand-400"
                                >
                                    Pilih Semua
                                </button>
                            </div>

                            <div id="permission-group-{{ Str::slug($category) }}" class="grid gap-1 p-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                                @foreach ($permissions as $permission)
                                    <label class="flex cursor-pointer items-center gap-2.5 rounded-lg px-2 py-1.5 transition hover:bg-gray-50 dark:hover:bg-white/5">
                                        <input
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->id }}"
                                            @checked(in_array($permission->id, $selectedPermissions))
                                            class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900"
                                        >
                                        <span class="text-theme-sm text-gray-600 dark:text-gray-400">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-gray-200 p-6 text-center dark:border-gray-800">
                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">Belum ada permission tersedia.</p>
                        </div>
                    @endforelse
                </div>

                @error('permissions')
                    <p class="mt-1.5 text-theme-xs text-error-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 px-6 py-4 dark:border-gray-800">
            <a
                href="{{ route('dashboard.roles.index') }}"
                class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
            >
                Batal
            </a>
            <button
                type="submit"
                class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
            >
                {{ $role ? 'Simpan Perubahan' : 'Simpan Role' }}
            </button>
        </div>
    </div>
</div>

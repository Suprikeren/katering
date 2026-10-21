@php
    $user = $user ?? null;
    $selectedRoles = old('roles', $user?->roles->pluck('id')->all() ?? []);
@endphp

<div class="col-span-12">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $user ? 'Data User' : 'Data User Baru' }}</h2>
        </div>

        <div class="grid gap-5 px-6 py-5">
            {{-- Name --}}
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user?->name) }}"
                    required
                    autofocus
                    placeholder="Nama lengkap"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 @error('name') border-error-500 @enderror"
                >
                @error('name')
                    <p class="mt-1.5 text-theme-xs text-error-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user?->email) }}"
                    required
                    placeholder="nama@contoh.com"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 @error('email') border-error-500 @enderror"
                >
                @error('email')
                    <p class="mt-1.5 text-theme-xs text-error-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password
                        @if ($user)
                            <span class="text-theme-xs font-normal text-gray-400">(kosongkan jika tidak diubah)</span>
                        @endif
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        @if (! $user) required @endif
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 @error('password') border-error-500 @enderror"
                    >
                    @error('password')
                        <p class="mt-1.5 text-theme-xs text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        @if (! $user) required @endif
                        placeholder="Ulangi password"
                        autocomplete="new-password"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500"
                    >
                </div>
            </div>

            {{-- Roles --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Role <span class="text-error-500">*</span></label>
                <p class="mb-3 text-theme-xs text-gray-400">Pilih satu atau lebih role (multi-role).</p>

                <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($roles as $role)
                        <label class="flex cursor-pointer items-center gap-2.5 rounded-lg border border-gray-200 px-3 py-2.5 transition hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-white/5">
                            <input
                                type="checkbox"
                                name="roles[]"
                                value="{{ $role->id }}"
                                @checked(in_array($role->id, $selectedRoles))
                                class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900"
                            >
                            <span class="text-theme-sm font-medium text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                        </label>
                    @empty
                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">Belum ada role tersedia.</p>
                    @endforelse
                </div>

                @error('roles')
                    <p class="mt-1.5 text-theme-xs text-error-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 px-6 py-4 dark:border-gray-800">
            <a
                href="{{ route('dashboard.users.index') }}"
                class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
            >
                Batal
            </a>
            <button
                type="submit"
                class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
            >
                {{ $user ? 'Simpan Perubahan' : 'Simpan User' }}
            </button>
        </div>
    </div>
</div>

{{-- Reusable modal untuk Create & Edit Permission --}}

<div
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
    class="fixed inset-0 z-999999 flex items-center justify-center overflow-y-auto bg-gray-900/50 p-4 backdrop-blur-sm"
    @click.self="close()"
    @keydown.escape.window="close()"
>
    <div
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="w-full max-w-lg rounded-2xl border border-gray-200 bg-white shadow-theme-xl dark:border-gray-800 dark:bg-gray-900"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90" x-text="isEdit ? 'Edit Permission' : 'Tambah Permission'"></h3>
            <button
                type="button"
                @click="close()"
                class="text-gray-400 transition hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-200"
            >
                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z" fill="" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <form :action="formAction" method="POST" class="px-6 py-5">
            @csrf

            <template x-if="isEdit">
                <input type="hidden" name="_method" value="PUT">
            </template>

            <template x-if="isEdit">
                <input type="hidden" name="permission_id" :value="permissionId">
            </template>

            <div>
                <label for="permission-name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input
                    type="text"
                    id="permission-name"
                    name="name"
                    x-model="name"
                    required
                    placeholder="contoh: user.index"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none transition focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 @error('name') border-error-500 @enderror"
                >
                @error('name')
                    <p class="mt-1.5 text-theme-xs text-error-500">{{ $message }}</p>
                @enderror
                <p class="mt-1.5 text-theme-xs text-gray-400">
                    Gunakan format kategori.tindakan, contoh: <code>user.index</code>, <code>user.create</code>.
                </p>
            </div>

            {{-- Footer --}}
            <div class="mt-6 flex items-center justify-end gap-3">
                <button
                    type="button"
                    @click="close()"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
                    x-text="isEdit ? 'Simpan Perubahan' : 'Simpan'"
                ></button>
            </div>
        </form>
    </div>
</div>

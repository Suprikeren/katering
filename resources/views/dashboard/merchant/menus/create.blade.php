@extends('layouts.admins.app')

@section('content')
    @include('dashboard.partials.header', [
        'title' => 'Tambah Menu',
        'subtitle' => 'Tambahkan menu baru untuk usaha katering Anda',
        'createLabel' => 'Kembali',
        'createUrl' => route('dashboard.merchant.menus.index'),
    ])

    <div class="col-span-12">
        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">

            {{-- Header Form --}}
            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Informasi Menu
                </h3>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Lengkapi informasi menu katering Anda.
                </p>
            </div>

            {{-- Form --}}
            <form action="{{ route('dashboard.merchant.menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-5 p-5">

                    {{-- Foto Menu: Paling Atas --}}
                    <div>
                        <label for="photo" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Foto Menu
                        </label>

                        {{-- Preview Foto --}}
                        <div class="mb-3">
                            <img
                                id="photo-preview"
                                src=""
                                alt="Preview foto menu"
                                class="hidden h-48 w-full rounded-xl border border-gray-200 object-cover sm:w-80 dark:border-gray-700"
                            >

                            <div
                                id="photo-placeholder"
                                class="flex h-48 w-full flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 sm:w-80 dark:border-gray-700 dark:bg-white/[0.03]"
                            >
                                <svg class="mb-2 h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5V6.75A2.25 2.25 0 015.25 4.5h13.5A2.25 2.25 0 0121 6.75v10.5a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 17.25v-.75zM3 16.5l5.25-5.25a2.25 2.25 0 013.182 0l2.318 2.318m0 0l1.5-1.5a2.25 2.25 0 013.182 0L21 16.5M15.75 9h.008v.008h-.008V9z" />
                                </svg>

                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Preview foto akan muncul di sini
                                </p>
                            </div>
                        </div>

                        <input
                            type="file"
                            id="photo"
                            name="photo"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:font-medium file:text-gray-700 hover:file:bg-gray-200 dark:text-gray-300 dark:file:bg-gray-800 dark:file:text-gray-300"
                        >

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Format JPG, PNG, atau WebP. Maksimal 2 MB.
                        </p>

                        @error('photo')
                            <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Menu --}}
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nama Menu <span class="text-error-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Nasi Ayam Bakar"
                            required
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-300 dark:border-gray-700 dark:bg-white/[0.03] dark:text-white/90"
                        >

                        @error('name')
                            <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="description" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Deskripsi Menu
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Jelaskan isi atau detail menu..."
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 outline-none focus:border-brand-300 dark:border-gray-700 dark:bg-white/[0.03] dark:text-white/90"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label for="price" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Harga (Rp) <span class="text-error-500">*</span>
                        </label>

                        <input
                            type="number"
                            id="price"
                            name="price"
                            value="{{ old('price') }}"
                            min="1"
                            placeholder="Contoh: 20000"
                            required
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-300 dark:border-gray-700 dark:bg-white/[0.03] dark:text-white/90"
                        >

                        @error('price')
                            <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Ketersediaan --}}
                    <div>
                        <label for="is_available" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Status Ketersediaan <span class="text-error-500">*</span>
                        </label>

                        <select
                            id="is_available"
                            name="is_available"
                            required
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                            <option value="yes" {{ old('is_available', 'yes') == 'yes' ? 'selected' : '' }}>
                                Tersedia
                            </option>

                            <option value="no" {{ old('is_available') == 'no' ? 'selected' : '' }}>
                                Tidak tersedia
                            </option>
                        </select>

                        @error('is_available')
                            <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="flex items-center justify-end gap-3 border-t border-gray-200 px-5 py-4 dark:border-gray-800">
                    <a
                        href="{{ route('dashboard.merchant.menus.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
                    >
                        Simpan Menu
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Preview Foto dengan JavaScript --}}
    <script>
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('photo-preview');
        const photoPlaceholder = document.getElementById('photo-placeholder');

        photoInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                if (!file.type.startsWith('image/')) {
                    this.value = '';
                    photoPreview.src = '';
                    photoPreview.classList.add('hidden');
                    photoPlaceholder.classList.remove('hidden');
                    return;
                }

                photoPreview.src = URL.createObjectURL(file);
                photoPreview.classList.remove('hidden');
                photoPlaceholder.classList.add('hidden');
            } else {
                photoPreview.src = '';
                photoPreview.classList.add('hidden');
                photoPlaceholder.classList.remove('hidden');
            }
        });
    </script>
@endsection

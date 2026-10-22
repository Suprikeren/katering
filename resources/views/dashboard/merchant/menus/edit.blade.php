@extends('layouts.admins.app')

@section('content')
    @include('dashboard.partials.header', [
        'title' => 'Edit Menu',
        'subtitle' => 'Perbarui menu katering Anda',
        'createLabel' => 'Kembali',
        'createUrl' => route('dashboard.merchant.menus.index'),
    ])

    <div class="col-span-12">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">

            <form action="{{ route('dashboard.merchant.menus.update', $menu->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6">

                @csrf
                @method('PUT')

                {{-- Foto Menu --}}
                <div>
                    <label for="photo" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Foto Menu
                    </label>

                    <div class="mb-4">
                        <img
                            id="photo-preview"
                            src="{{ $menu->photo ? asset('storage/' . $menu->photo) : '' }}"
                            alt="Preview Foto Menu"
                            class="{{ $menu->photo ? '' : 'hidden' }} h-48 w-full rounded-xl border border-gray-200 object-cover sm:w-80"
                        >

                        <div
                            id="photo-placeholder"
                            class="{{ $menu->photo ? 'hidden' : '' }} flex h-48 w-full items-center justify-center rounded-xl border border-dashed border-gray-300 text-sm text-gray-500 sm:w-80"
                        >
                            Belum ada foto menu
                        </div>
                    </div>

                    <input
                        type="file"
                        name="photo"
                        id="photo"
                        accept="image/jpeg,image/png,image/webp"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:font-medium file:text-white hover:file:bg-brand-600"
                    >

                    <p class="mt-1 text-xs text-gray-500">
                        Kosongkan jika tidak ingin mengganti foto. Format JPG, JPEG, PNG, atau WEBP, maksimal 2 MB.
                    </p>

                    @error('photo')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Menu --}}
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama Menu
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $menu->name) }}"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white"
                        placeholder="Contoh: Nasi Ayam Bakar"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white"
                        placeholder="Masukkan deskripsi menu"
                    >{{ old('description', $menu->description) }}</textarea>

                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label for="price" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Harga (Rp)
                    </label>

                    <input
                        type="number"
                        name="price"
                        id="price"
                        value="{{ old('price', $menu->price) }}"
                        min="1"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white"
                        placeholder="Contoh: 25000"
                    >

                    @error('price')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="is_available" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Status Menu
                    </label>

                    <select
                        name="is_available"
                        id="is_available"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white"
                    >
                        <option value="yes" {{ old('is_available', $menu->is_available) == 'yes' ? 'selected' : '' }}>
                            Tersedia
                        </option>
                        <option value="no" {{ old('is_available', $menu->is_available) == 'no' ? 'selected' : '' }}>
                            Tidak Tersedia
                        </option>
                    </select>

                    @error('is_available')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3">
                    <a
                        href="{{ route('dashboard.merchant.menus.index') }}"
                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
                    >
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('photo-preview');
        const photoPlaceholder = document.getElementById('photo-placeholder');

        photoInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                if (!file.type.startsWith('image/')) {
                    this.value = '';
                    return;
                }

                photoPreview.src = URL.createObjectURL(file);
                photoPreview.classList.remove('hidden');
                photoPlaceholder.classList.add('hidden');
            }
        });
    </script>
@endsection

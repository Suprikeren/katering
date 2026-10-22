
@extends('layouts.admins.app')

@section('content')
    <div class="col-span-12 space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
                Profil Usaha
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Kelola informasi akun dan usaha katering Anda.
            </p>
        </div>

        <form
            action="{{ route('dashboard.merchant.profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            {{-- Informasi Akun --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 sm:p-6">
                <h2 class="mb-5 text-base font-semibold text-gray-800 dark:text-white">
                    Informasi Akun
                </h2>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nama Akun
                        </label>
                        <input
                            id="name"
                            type="text"
                            value="{{ auth()->user()->name }}"
                            disabled
                            class="h-11 w-full rounded-lg border border-gray-300 bg-gray-100 px-4 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                        >
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Nama akun belum dapat diubah di halaman ini.
                        </p>
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            value="{{ auth()->user()->email }}"
                            disabled
                            class="h-11 w-full rounded-lg border border-gray-300 bg-gray-100 px-4 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                        >
                    </div>
                </div>
            </div>

            {{-- Informasi Usaha --}}
            <div class="space-y-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 sm:p-6">
                <h2 class="text-base font-semibold text-gray-800 dark:text-white">
                    Informasi Usaha Katering
                </h2>

                {{-- Logo Usaha --}}
                <div>
                    <label for="icon" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Logo Usaha
                    </label>

                    <div class="mb-3 flex h-32 w-32 items-center justify-center overflow-hidden rounded-xl border border-dashed border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">
                        <img
                            id="icon-preview"
                            src="{{ $merchant->icon ? asset('storage/' . $merchant->icon) : '' }}"
                            alt="Preview logo usaha"
                            class="{{ $merchant->icon ? '' : 'hidden' }} h-full w-full object-cover"
                        >
                        <span
                            id="icon-placeholder"
                            class="{{ $merchant->icon ? 'hidden' : '' }} px-3 text-center text-sm text-gray-400"
                        >
                            Preview logo usaha
                        </span>
                    </div>

                    <input
                        id="icon"
                        name="icon"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        onchange="previewImage(this, 'icon-preview', 'icon-placeholder')"
                        class="block w-full text-sm text-gray-500 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-500 file:px-3 file:py-2 file:text-white"
                    >

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                    </p>

                    @error('icon')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Foto / Banner Usaha --}}
                <div>
                    <label for="thumbnail" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Foto / Banner Usaha
                    </label>

                    <div class="mb-3 flex h-40 w-full max-w-lg items-center justify-center overflow-hidden rounded-xl border border-dashed border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">
                        <img
                            id="thumbnail-preview"
                            src="{{ $merchant->thumbnail ? asset('storage/' . $merchant->thumbnail) : '' }}"
                            alt="Preview banner usaha"
                            class="{{ $merchant->thumbnail ? '' : 'hidden' }} h-full w-full object-cover"
                        >
                        <span
                            id="thumbnail-placeholder"
                            class="{{ $merchant->thumbnail ? 'hidden' : '' }} px-3 text-center text-sm text-gray-400"
                        >
                            Preview banner usaha
                        </span>
                    </div>

                    <input
                        id="thumbnail"
                        name="thumbnail"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        onchange="previewImage(this, 'thumbnail-preview', 'thumbnail-placeholder')"
                        class="block w-full text-sm text-gray-500 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-500 file:px-3 file:py-2 file:text-white"
                    >

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Format JPG, PNG, atau WEBP. Maksimal 5 MB.
                    </p>

                    @error('thumbnail')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Usaha --}}
                <div>
                    <label for="company_name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama Usaha
                    </label>
                    <input
                        id="company_name"
                        name="company_name"
                        type="text"
                        value="{{ old('company_name', $merchant->company_name) }}"
                        placeholder="Contoh: Dapur Sejahtera"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white"
                    >
                    @error('company_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nomor Telepon
                    </label>
                    <input
                        id="phone"
                        name="phone"
                        type="text"
                        value="{{ old('phone', $merchant->phone) }}"
                        placeholder="Contoh: 081234567890"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white"
                    >
                    @error('phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Makanan --}}
                <div>
                    <label for="food_type" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Jenis Makanan
                    </label>
                    <input
                        id="food_type"
                        name="food_type"
                        type="text"
                        value="{{ old('food_type', $merchant->food_type) }}"
                        placeholder="Contoh: Masakan rumahan, nasi kotak, snack"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white"
                    >
                    @error('food_type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat Usaha --}}
                <div>
                    <label for="address" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Alamat Usaha
                    </label>
                    <textarea
                        id="address"
                        name="address"
                        rows="3"
                        placeholder="Masukkan alamat lengkap usaha"
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white"
                    >{{ old('address', $merchant->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Lokasi Usaha --}}
                <div>
                    <label for="location" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Lokasi Usaha
                    </label>
                    <input
                        id="location"
                        name="location"
                        type="text"
                        value="{{ old('location', $merchant->location) }}"
                        placeholder="Contoh: Utan, Sumbawa, Nusa Tenggara Barat"
                        class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white"
                    >
                    @error('location')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi Usaha --}}
                <div>
                    <label for="description" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Deskripsi Usaha
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Ceritakan tentang usaha katering Anda"
                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 outline-none focus:border-brand-500 dark:border-gray-700 dark:text-white"
                    >{{ old('description', $merchant->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Tombol Simpan --}}
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-5 text-sm font-medium text-white transition hover:bg-brand-600"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection

<script>
    function previewImage(input, previewId, placeholderId) {
        const preview = document.getElementById(previewId);
        const placeholder = document.getElementById(placeholderId);

        if (!input.files || !input.files[0]) {
            return;
        }

        const file = input.files[0];

        if (!file.type.startsWith('image/')) {
            input.value = '';
            alert('Silakan pilih file gambar.');
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            preview.src = event.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };

        reader.readAsDataURL(file);
    }
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>{{ $title ?? 'Authentication' }}</title>

    @vite(['resources/css/admin.css', 'resources/js/admin/index.js'])
</head>

<body x-data="{
    darkMode: JSON.parse(localStorage.getItem('darkMode')) || false
}" x-init="$watch('darkMode', value => {
    localStorage.setItem('darkMode', JSON.stringify(value))
})" :class="{ 'dark bg-gray-900': darkMode === true }"
    class="min-h-screen bg-gray-50">

    <main class="flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-8">

        <div class="w-full max-w-md">

            {{-- Logo / Brand --}}
            <div class="mb-8 text-center">
                <a href="/" class="inline-flex items-center justify-center">
                    <span class="text-2xl font-bold text-gray-800 dark:text-white">
                        YourApp
                    </span>
                </a>
            </div>

            {{-- Authentication Content --}}
            @yield('content')

        </div>

    </main>

</body>

</html>


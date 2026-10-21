@php
    $message = $message ?? 'Belum ada data.';
@endphp

<div class="flex flex-col items-center justify-center gap-3 px-5 py-14 text-center">
    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
        <svg class="fill-gray-400 dark:fill-gray-500" width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.5 6C3.5 4.75736 4.50736 3.75 5.75 3.75H8.5C8.91421 3.75 9.25 4.08579 9.25 4.5V5.25H14.75V4.5C14.75 4.08579 15.0858 3.75 15.5 3.75H18.25C19.4926 3.75 20.5 4.75736 20.5 6V18C20.5 19.2426 19.4926 20.25 18.25 20.25H5.75C4.50736 20.25 3.5 19.2426 3.5 18V6ZM5 9.75V18C5 18.4142 5.33579 18.75 5.75 18.75H18.25C18.6642 18.75 19 18.4142 19 18V9.75H5ZM5 8.25H19V6C19 5.58579 18.6642 5.25 18.25 5.25H16.25V6C16.25 6.41421 15.9142 6.75 15.5 6.75H8.5C8.08579 6.75 7.75 6.41421 7.75 6V5.25H5.75C5.33579 5.25 5 5.58579 5 6V8.25Z" fill="" />
        </svg>
    </div>
    <p class="text-theme-sm font-medium text-gray-500 dark:text-gray-400">{{ $message }}</p>
</div>

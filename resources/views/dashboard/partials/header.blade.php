@php
    $title = $title ?? '';
    $subtitle = $subtitle ?? '';
    $createLabel = $createLabel ?? null;
    $createUrl = $createUrl ?? null;
    $createOnClick = $createOnClick ?? null;
@endphp

<div class="col-span-12 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-title-md font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h1>
        <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
    </div>

    @if ($createLabel)
        @if ($createOnClick)
            <button
                type="button"
                @click="{{ $createOnClick }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
            >
                <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.99992 2.75C8.41413 2.75 8.74992 3.08579 8.74992 3.5V7.25H12.4999C12.9141 7.25 13.2499 7.58579 13.2499 8C13.2499 8.41421 12.9141 8.75 12.4999 8.75H8.74992V12.5C8.74992 12.9142 8.41413 13.25 7.99992 13.25C7.58571 13.25 7.24992 12.9142 7.24992 12.5V8.75H3.49992C3.08571 8.75 2.74992 8.41421 2.74992 8C2.74992 7.58579 3.08571 7.25 3.49992 7.25H7.24992V3.5C7.24992 3.08579 7.58571 2.75 7.99992 2.75Z" fill="" />
                </svg>
                {{ $createLabel }}
            </button>
        @elseif ($createUrl)
            <a
                href="{{ $createUrl }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
            >
                <svg class="fill-current" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.99992 2.75C8.41413 2.75 8.74992 3.08579 8.74992 3.5V7.25H12.4999C12.9141 7.25 13.2499 7.58579 13.2499 8C13.2499 8.41421 12.9141 8.75 12.4999 8.75H8.74992V12.5C8.74992 12.9142 8.41413 13.25 7.99992 13.25C7.58571 13.25 7.24992 12.9142 7.24992 12.5V8.75H3.49992C3.08571 8.75 2.74992 8.41421 2.74992 8C2.74992 7.58579 3.08571 7.25 3.49992 7.25H7.24992V3.5C7.24992 3.08579 7.58571 2.75 7.99992 2.75Z" fill="" />
                </svg>
                {{ $createLabel }}
            </a>
        @endif
    @endif
</div>

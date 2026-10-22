
@extends('layouts.customer.app')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">

    <div class="mb-8">
        <p class="text-sm font-medium text-orange-600">Area Customer</p>
        <h1 class="mt-1 text-2xl font-bold text-gray-900">
            Invoice Saya
        </h1>
        <p class="mt-2 text-sm text-gray-500">
            Lihat tagihan dan detail pesanan katering Anda.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-xl bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($invoices->isEmpty())
        <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-orange-50 text-orange-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                </svg>
            </div>

            <h2 class="mt-4 text-lg font-semibold text-gray-900">
                Belum ada invoice
            </h2>
            <p class="mt-2 text-sm text-gray-500">
                Invoice pesanan Anda akan muncul di halaman ini.
            </p>

            <a href="{{ route('home.caterings') }}"
                class="mt-6 inline-flex rounded-xl bg-orange-500 px-5 py-3 text-sm font-semibold text-white hover:bg-orange-600">
                Lihat Katering
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($invoices as $invoice)
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="min-w-0">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Nomor Invoice
                            </p>
                            <h2 class="mt-1 break-all text-base font-bold text-gray-900">
                                {{ $invoice->invoice_number }}
                            </h2>

                            <p class="mt-3 text-sm text-gray-600">
                                Merchant:
                                <span class="font-semibold text-gray-800">
                                    {{ $invoice->order->merchant->company_name ?? 'Merchant' }}
                                </span>
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Diterbitkan:
                                {{ $invoice->issued_at->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <div class="sm:text-right">
                            <p class="text-sm text-gray-500">Total tagihan</p>
                            <p class="mt-1 text-xl font-bold text-gray-900">
                                Rp{{ number_format($invoice->order->total, 0, ',', '.') }}
                            </p>

                            <span class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                {{ $invoice->order->status === 'completed'
                                    ? 'bg-green-100 text-green-700'
                                    : ($invoice->order->status === 'cancelled'
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-orange-100 text-orange-700') }}">
                                {{ ucfirst($invoice->order->status) }}
                            </span>

                            <div>
                                <a href="{{ route('home.invoices.show', $invoice->id) }}"
                                    class="mt-4 inline-flex items-center gap-2 rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600">
                                    Lihat Detail
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection

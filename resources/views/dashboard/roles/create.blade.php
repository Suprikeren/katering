@extends('layouts.admins.app')

@section('content')
    @include('dashboard.partials.header', [
        'title' => 'Tambah Role',
        'subtitle' => 'Buat role baru beserta permission-nya',
    ])

    <form method="POST" action="{{ route('dashboard.roles.store') }}" class="contents">
        @csrf
        @include('dashboard.roles._form', ['role' => null])
    </form>
@endsection

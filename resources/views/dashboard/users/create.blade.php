@extends('layouts.admins.app')

@section('content')
    @include('dashboard.partials.header', [
        'title' => 'Tambah User',
        'subtitle' => 'Buat user baru beserta role-nya',
    ])

    <form method="POST" action="{{ route('dashboard.users.store') }}" class="contents">
        @csrf
        @include('dashboard.users._form', ['user' => null])
    </form>
@endsection

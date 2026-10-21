@extends('layouts.admins.app')

@section('content')
    @include('dashboard.partials.header', [
        'title' => 'Edit User',
        'subtitle' => 'Perbarui data dan role user',
    ])

    <form method="POST" action="{{ route('dashboard.users.update', $user) }}" class="contents">
        @csrf
        @method('PUT')
        @include('dashboard.users._form', ['user' => $user])
    </form>
@endsection

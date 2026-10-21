@extends('layouts.admins.app')

@section('content')
    @include('dashboard.partials.header', [
        'title' => 'Edit Role',
        'subtitle' => 'Perbarui nama role dan permission-nya',
    ])

    <form method="POST" action="{{ route('dashboard.roles.update', $role) }}" class="contents">
        @csrf
        @method('PUT')
        @include('dashboard.roles._form', ['role' => $role])
    </form>
@endsection

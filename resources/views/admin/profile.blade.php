@extends('layouts.admin.main')

@section('title', 'Profile')

<!-- @push('styles')

@endpush -->

@section('content')

<div class="mt-4">
    <h1>{{ Auth::user()->name }}'s Profile</h1>
    <h5>Email : {{ Auth::user()->email }}</h5>
</div>

<a href="{{ route('AdminLogout') }}" class="btn btn-outline-danger rounded-0 mt-3">Logout</a>

@endsection
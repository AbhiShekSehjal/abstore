@extends('layouts.main')

@section('title', 'Profile')

@section('content')

<div class="container py-4">
    <h1>{{ Auth::user()->name }}'s Profile</h1>
    <h5>Email : {{ Auth::user()->email }}</h5>
    <a href="{{ route('Logout') }}" class="btn btn-outline-danger rounded-0 mt-3">Logout</a>
</div>


@endsection
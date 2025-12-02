@extends('layouts.main')

@section('title', 'Home')

@section('content')

<div class="mt-5">
    <h1>{{ Auth::user()->name }}'s Profile</h1>
    <h5>Email : {{ Auth::user()->email }}</h5>
</div>

<a href="{{ route('Logout') }}" class="btn btn-outline-danger rounded-0 mt-3">Logout</a>

@endsection
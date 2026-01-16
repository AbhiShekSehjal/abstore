@extends('layouts.admin.main')

@section('title', 'Users')

<!-- @push('styles')

@endpush -->

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-1">
        <h3><b>Users</b></h3>
    </div>

    <table class="table table-hover table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
            </tr>
        </thead>
        <tbody>

            @forelse($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->role}}</td>
                @empty
                <div class="text-center">
                    <h3>No User Found.</h3>
                </div>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
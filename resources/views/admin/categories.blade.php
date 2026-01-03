@extends('layouts.admin.main')

@section('title', 'Home')

<!-- @push('styles')

@endpush -->

@section('content')

<h1 class='mt-4'>Categories page admin</h1>

<table class="table table-hover table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td>John</td>
            <td>Doe</td>
            <td>@social</td>
        </tr>
    </tbody>
</table>

@endsection
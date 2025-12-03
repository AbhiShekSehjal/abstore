@extends('layouts.admin.main')

@section('title', 'Home')

@push('styles')
<style>
.countBox {
    text-decoration: none;
}

.countBox:hover {
    background: #000000ff !important;
    transition: all 0.6s ease !important;
    cursor: pointer;
}
</style>
@endpush

@section('content')

<h1 class='mt-4'>Dashboard</h1>

<div class="row p-3 d-flex flex-wrap">
    <a href='/admin/products'
        class="col-lg-4 bg-secondary border p-5 text-white d-flex align-items-center justify-content-between countBox">
        <h1>Products</h1>
        <h1><b>{{ $products->count() }}</b></h1>
    </a>
    <a href='/admin/categories'
        class="col-lg-4 bg-secondary border p-5 text-white d-flex align-items-center justify-content-between countBox">
        <h1>Categories</h1>
        <h1><b>{{ $categories->count() }}</b></h1>
    </a>
    <a href='/admin/orders'
        class="col-lg-4 bg-secondary border p-5 text-white d-flex align-items-center justify-content-between countBox">
        <h1>Orders</h1>
        <h1><b>{{ $orders->count() }}</b></h1>
    </a>
    <a href='/admin/users'
        class="col-lg-4 bg-secondary border p-5 text-white d-flex align-items-center justify-content-between countBox">
        <h1>Users</h1>
        <h1><b>{{ $users->count() }}</b></h1>
    </a>
</div>

@endsection
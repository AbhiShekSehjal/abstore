@extends('layouts.main')

@section('title', 'Product')

@push('styles')
<style>
.productcard {
    border: none;
    border: 1px solid white;
    overflow: hidden;
    padding: 0;
}

.card-img-top {
    height: 400px;
    object-fit: cover;
    border-radius: 0px;
}

.productcard:hover .card-img-top {
    transform: scale(1.06);
    transition: all 0.5s ease;
}

.productHeading {
    font-size: 40px;
    text-align: center;
}

.card-text {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush

@section('content')
<div class="row flex-wrap my-5">
    <div class="col-lg-6">
        <img src="{{ $product->image }}" alt="Image of {{ $product->name }}" class='rounded-5 w-100'>
    </div>

    <div class="col-lg-6">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="/products">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->category->name }}</li>
            </ol>
        </nav>

        <h1 style="text-transform: capitalize;">{{ $product->name }}</h1>

        <p>{{ $product->description }}</p>

        <h5><b>{{ $product->sale_price }} ₹</b></h5>

        <p>Stock Available : {{ $product->stock }}</p>

        <hr>

        <button class='btn btn-lg btn-outline-dark rounded-0 px-4 py-2'>Add to cart</button>
        <button class='btn btn-lg btn-success rounded-0 px-4 py-2'>Buy Now</button>

    </div>
</div>

<div class="d-flex justify-content-center mb-4">
    <hr class='w-50'>
</div>

<div class="forthSection overflow-hidden">
    <h1 class='productHeading mb-5'>Related Products</h1>

    <div class="products mt-5">
        <div class="row d-flex align-items-center justify-content-between flex-wrap">
            @foreach($products as $product)
            <div class="card rounded-0 col-lg-4 productcard">
                <div class="productImage overflow-hidden">
                    <a href="{{ $product->id }}">
                        <img src="{{ $product->image }}" class="card-img-top" alt="Image of {{ $product->name }}">
                    </a>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description}}</p>
                    <a href="#" class="btn btn-outline-dark rounded-0">Add to cart</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-center my-5">
        <a href='/products' class='btn btn-lg btn-outline-success rounded-0'>More</a>
    </div>

</div>

@endsection
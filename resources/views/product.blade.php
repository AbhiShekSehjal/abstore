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

.card {
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
}

.card-body {
    padding-bottom: 30px;
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

        <h5><span class="fw-bold fs-5">{{ $product->price }} &#8377;</span>
            &nbsp;&nbsp;<del class="fs-6">{{ $product->sale_price }} &#8377;</del>
        </h5>

        <p class="card-discount">{{ $product->discount }} % off</p>

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
    <h1 class='productHeading'>Related Products</h1>
    <p class="mt-2 text-center mb-5">Products which are related to this product</p>

    <div class="products">


        <div class="row g-1">
            @forelse($products as $product)
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="card rounded-0 productcard h-100">
                    <div class="productImage overflow-hidden">
                        <a href="product/{{ $product->id }}">
                       @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top">
                        @else
                        <img src="{{ asset('images/no-image.png') }}" class="card-img-top">
                        @endif
                        </a>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>

                        <p class="card-price mt-auto">
                            <span class="fw-bold fs-5">{{ $product->price }} &#8377;</span>
                            &nbsp;&nbsp;<del>{{ $product->sale_price }} &#8377;</del>
                        </p>
                        <p class="card-discount">{{ $product->discount }} % off</p>


                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-dark rounded-0 w-100">Add to cart</a>
                            <a href="#" class="btn btn-success rounded-0 w-100">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <h3>No products found for {{ $product->category->name }}</h3>
            </div>
            @endforelse
        </div>
    </div>

    <div class="d-flex justify-content-center my-5">
        <a href='/products?category={{ $product->category->id }}'
            class='btn btn-lg btn-outline-success rounded-0'>More</a>
    </div>

</div>

@endsection
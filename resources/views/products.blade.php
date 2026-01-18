@extends('layouts.main')

@section('title', 'Products')

@push('styles')
<style>
    .products {
        overflow: hidden;
    }

    .productcard {
        border: none;
        border: 1px solid white;
        overflow: hidden;
        padding: 0;
    }

    .card {
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
    }

    .card-body {
        padding-bottom: 30px;
    }

    .card-img-top {
        height: 400px;
        object-fit: cover;
        border-radius: 0 !important;

    }

    .productcard:hover .card-img-top {
        transform: scale(1.06);
        transition: all 0.5s ease;
    }

    .card-text {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .form-check-input[type=radio] {
        border-radius: 0;
    }

    .filterSection {
        position: sticky;
        top: 80px;
    }

    label{
        cursor: pointer;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="d-lg-none mb-1 mt-2">
            <button class="btn btn-dark rounded-0 w-100" data-bs-toggle="collapse" data-bs-target="#filterCollapse"
                aria-expanded="false">
                ☰ Filter
            </button>
        </div>


        <div class="col-lg-3 col-md-12 mb-4 border-end pt-3 pe-3 ps-3
            collapse d-lg-block filterSection" id="filterCollapse">
            <form method="GET" action="{{ route('products') }}">
                <b class='fs-4'>Filter</b>
                <hr>

                <p class='fs-4'>Categories</p>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="category" value="" id="all"
                        {{ request('category') == null ? 'checked' : '' }}>
                    <label class="form-check-label" for="all">All Categories</label>
                </div>

                @foreach($Categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="category" value="{{ $category->id }}" id="{{ $category->name }}"
                        {{ request('category') == $category->id ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $category->name }}">{{ $category->name }}</label>
                </div>
                @endforeach

                <hr>

                <p class='fs-4'>Sort by</p>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sort" value="discount" id="discount"
                        {{ request('sort')=='discount' ? 'checked' : '' }}>
                    <label class="form-check-label" for="discount">Discount</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sort" value="low_price" id="lowPrice"
                        {{ request('sort')=='low_price' ? 'checked' : '' }}>
                    <label class="form-check-label" for="lowPrice">Low Price</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sort" value="high_price" id="highPrice"
                        {{ request('sort')=='high_price' ? 'checked' : '' }}>
                    <label class="form-check-label" for="highPrice">High Price</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sort" value="stock" id="stock"
                        {{ request('sort')=='stock' ? 'checked' : '' }}>
                    <label class="form-check-label" for="stock">Stock</label>
                </div>

                <hr>

                <p class='fs-4'>Price</p>

                <input type="range" class="form-range" name="price" min="0" max="10000"
                    value="{{ request('price', 10000) }}" id="range4">
                <output id="rangeValue">{{ request('price', 10000) }} ₹</output>

                <hr>

                <div class="d-flex gap-2">
                    <button class='btn btn-dark rounded-0 w-100'>Show</button>
                    <a href="{{ route('products') }}" class="btn btn-outline-dark rounded-0 w-100">Clear</a>
                </div>
            </form>
        </div>

        <div class="col-lg-9 col-md-12">
            <div class="products">
                @if ($products->count() > 0)
                <h1 class="mt-2 text-center">Products</h1>
                <p class="mt-2 text-center">Discover our wide range of products</p>
                @endif

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
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-dark rounded-0 w-100">
                                            Add to cart
                                        </button>
                                    </form>
                                    <a href="{{ route('buy.now', $product->id) }}" class="btn btn-success rounded-0 w-100">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <h3>No products found.</h3>
                        <p>Try adjusting your filters or search term.</p>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    const rangeInput = document.getElementById('range4');
    const rangeOutput = document.getElementById('rangeValue');

    rangeOutput.textContent = rangeInput.value + " ₹";

    rangeInput.addEventListener('input', function() {
        rangeOutput.textContent = this.value + " ₹";
    });
</script>
@endpush
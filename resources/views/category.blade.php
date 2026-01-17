@extends('layouts.main')

@section('title', 'Category')

@push('styles')
<style>
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
        border-radius: 0px;
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
</style>
@endpush

@section('content')

<div class="forthSection overflow-hidden">
    @if ($category->count() > 0)
    <h1 class='text-center mb-2 mt-2'>{{ $category->name }}</h1>
    @endif

    <div class="row g-1">
        @forelse($items as $item)
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="card rounded-0 productcard h-100">
                <div class="productImage overflow-hidden">
                    <a href="product/{{ $item->id }}">
                        @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top">
                        @else
                        <img src="{{ asset('images/no-image.png') }}" class="card-img-top">
                        @endif
                    </a>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->description }}</p>

                    <p class="card-price mt-auto">
                        <span class="fw-bold fs-5">{{ $item->price }} &#8377;</span>
                        &nbsp;&nbsp;<del>{{ $item->sale_price }} &#8377;</del>
                    </p>
                    <p class="card-discount">{{ $item->discount }} % off</p>

                    <div class="d-flex gap-2">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark rounded-0 w-100">
                                Add to cart
                            </button>
                        </form>
                        <a href="#" class="btn btn-success rounded-0 w-100">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <h3>No products for {{ $category->name }}.</h3>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center my-5">
        <a href='/products?category={{ $category->id }}' class='btn btn-lg btn-outline-success rounded-0'>More</a>
    </div>

</div>


@endsection
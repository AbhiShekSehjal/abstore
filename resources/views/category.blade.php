@extends('layouts.main')

@section('title', 'Home')

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
    font-size: 60px;
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

<div class="forthSection overflow-hidden mt-5">
    <h1 class='productHeading mb-5'>{{ $category->name }}</h1>

    <div class="products">
        <div class="row d-flex align-items-center justify-content-between flex-wrap">
            @foreach($items as $item)
            <div class="card rounded-0 col-lg-4 productcard">
                <div class="productImage overflow-hidden">
                    <a href="product/{{ $item->id }}">
                        <img src="{{ $item->image }}" class="card-img-top" alt="Image of {{ $item->name }}">
                    </a>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->description}}</p>
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
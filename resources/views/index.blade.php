@extends('layouts.main')

@section('title', 'Home')

@push('styles')
<style>
.banner {
    position: relative;
}

.heroImage {
    width: 100%;
    height: 60vh;
    object-fit: cover;
}

.heroText {
    position: absolute;
    font-family: "Jost", sans-serif;
    font-size: 80px;
    font-weight: 600;
    color: white;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    text-align: center;
}

.overfade {
    position: absolute;
    top: 0;
    left: 0;
    background: #0000004c;
    width: 100%;
    height: 100%;
}

.splide {
    height: 500px !important;
    overflow: hidden;
}

.sliderImg {
    width: 100%;
    font-family: "Jost", sans-serif;
    height: 100%;
    object-fit: cover;
    transition: all 0.1s ease;
    overflow: hidden;
}

.sliderImg:hover {
    height: 110%;
    filter: grayscale(100%);
}

.categoryName {
    position: absolute;
    font-family: "Jost", sans-serif;
    top: 0;
    left: 15px;
    font-size: 50px;
    color: white;
}

.splide__slide {
    position: relative;
}

.showMoreBtn:hover {
    border: 2px solid;
}

.thirdSection {
    background: grey;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    gap: 20px;
    flex-wrap: wrap;
}

.thirdSectionRightSideText {
    font-size: 60px;
    font-weight: 600;
    font-family: "Jost", sans-serif;
    color: white;
}

.productcard {
    border: none;
    border: 1px solid white;
    overflow: hidden;
    padding: 0;
}

.card {
    box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
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


@media screen and (max-width: 600px) {
    #main-slider {
        height: 200px !important;
    }
}
</style>
@endpush

@section('content')

<div class="banner">
    <img src="https://res.cloudinary.com/djmmx0tri/image/upload/v1763627143/26963_zy95ek.jpg" alt="" class='heroImage'>

    <div class="overfade"></div>

    <div class="heroText">Fashion That Fits You Perfectly
        <p class='fs-6 opacity-75'>Refresh your style with fashion that feels good, looks great, and fits perfectly.</p>
    </div>

</div>

<div id="main-slider" class="splide mt-5 mb-5" aria-label="Main Slider">
    <div class="splide__track">

        <ul class="splide__list">
            @forelse($categories as $category)
            <li class="splide__slide">
                <a href="category/{{ $category->id }}">
                    <img class='sliderImg' src="{{ $category->category_image }}" alt="Slide 1">
                    <p class='categoryName'>{{ $category->name }}</p>
                </a>
            </li>
            @empty
            <div class="text-center">
                <h3>No category found.</h3>
            </div>
            @endforelse
        </ul>
    </div>
</div>

<div class="thirdSection mb-5">
    <img src="https://images.unsplash.com/photo-1729487151777-b4be9098ecbb?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
        class='offerImg img-fluid' alt="offer-img">
    <div class="thirdSectionRightSideText">Buy 2 Get 1 Free
        <br>
        <a href='/products' class='btn btn-light btn-lg rounded-0'>Shop</a>
    </div>
</div>

<div class="forthSection overflow-hidden">
    <h1 class='productHeading mb-5'>Our Products</h1>

    <div class="row g-1">
        @forelse($products as $product)
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="card rounded-0 productcard h-100">
                <div class="productImage overflow-hidden">
                    <a href="product/{{ $product->id }}">
                        <img src="{{ $product->image }}" class="card-img-top" alt="Image of {{ $product->name }}">
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
            <h3>No products found</h3>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center my-5">
        <a href='/products' class='btn btn-lg btn-outline-success rounded-0'>More</a>
    </div>

</div>

@endsection

@push('scripts')
<script>
var splide = new Splide('.splide', {
    type: 'loop',
    perPage: 3,
    focus: 'center',
    autoplay: true,
    interval: 2000,
    pauseOnHover: true,
    pauseOnFocus: true,
});

splide.mount();
</script>
@endpush
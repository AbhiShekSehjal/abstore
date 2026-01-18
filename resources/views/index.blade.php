@extends('layouts.main')

@section('title', 'Home')

@push('styles')
<style>
    .banner {
        position: relative;
    }

    .heroImage {
        width: 100%;
        height: 85vh;
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
        background: rgba(0, 0, 0, 0.6);
        width: 100%;
        height: 100%;
    }

    .splide {
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

    .thirdSection {
        background-color: #f8f9fa;
    }

    .thirdSectionContent h2 {
        font-size: 2.4rem;
        font-weight: 700;
        color: #111;
    }

    .thirdSectionContent p {
        font-size: 1.05rem;
        line-height: 1.7;
    }

    .imageWrapper {
        width: 100%;
        height: 450px;
        overflow: hidden;
    }

    .offerImg {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }


    @media (max-width: 768px) {
        .thirdSectionContent h2 {
            font-size: 1.8rem;
        }
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
    @if($settings)
    <div class="splide splideMain">
        <div class="splide__track">
            <ul class="splide__list">
                <li class="splide__slide">@if($settings->slider_image_1)
                    <img src="{{ asset('storage/' . $settings->slider_image_1) }}" alt="Slider 1" class='heroImage'>
                    @endif
                </li>
                <li class="splide__slide">@if($settings->slider_image_2)
                    <img src="{{ asset('storage/' . $settings->slider_image_2) }}" alt="Slider 2" class='heroImage'>
                    @endif
                </li>
                <li class="splide__slide"> @if($settings->slider_image_3)
                    <img src="{{ asset('storage/' . $settings->slider_image_3) }}" alt="Slider 3" class='heroImage'>
                    @endif
                </li>

            </ul>
        </div>
    </div>
    @endif


    <div class="overfade"></div>

    <div class="heroText">@if($settings->main_heading)
        {{$settings->main_heading}}
        @endif
        <p class='fs-6 opacity-75'>
            @if($settings->main_pera)
            {{$settings->main_pera}}
            @endif
        </p>
    </div>

</div>

<div id="main-slider" class="splide mt-5 mb-5" aria-label="Main Slider">
    <div class="splide__track">
        <ul class="splide__list">

            @forelse($categories as $category)
            <li class="splide__slide">
                <a href="{{ url('category/' . $category->id) }}">

                    @if($category->category_image)
                    <img
                        class="sliderImg"
                        src="{{ asset('storage/' . $category->category_image) }}"
                        alt="{{ $category->name }}">
                    @else
                    <img
                        class="sliderImg"
                        src="{{ asset('images/no-image.png') }}"
                        alt="No image">
                    @endif

                    <p class="categoryName">{{ $category->name }}</p>
                </a>
            </li>
            @empty
            <li class="text-center">
                <h3>No category found.</h3>
            </li>
            @endforelse

        </ul>
    </div>
</div>

@if($settings->Section_3_Image)
<section class="thirdSection p-5 mb-5">
    <div class="container">
        <div class="row align-items-center g-4">

            <!-- LEFT : IMAGE -->
            <div class="col-lg-6 text-center">
                <div class="imageWrapper">
                    <img
                        src="{{ asset('storage/' . $settings->Section_3_Image) }}"
                        alt="Offer Image"
                        class="offerImg">
                </div>
            </div>

            <!-- RIGHT : TEXT -->
            <div class="col-lg-6">
                <div class="thirdSectionContent">
                    @if($settings->Section_3_Text)
                    <h2 class="mb-3">
                        {{ $settings->Section_3_Text }}
                    </h2>
                    @endif

                    <p class="text-muted mb-4">
                        {{ $settings->Section_3_Text2 }}
                    </p>

                    <a href="/products" class="btn btn-dark btn-lg rounded-0 px-5">
                        Shop Now
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endif


<div class="forthSection overflow-hidden">
    <h1 class='productHeading mb-5'>Our Products</h1>

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
    // Main category slider
    var categorySlider = new Splide('.splide:not(.splideMain)', {
        type: 'loop',
        perPage: 3,
        focus: 'center',
        autoplay: true,
        interval: 2000,
        pauseOnHover: true,
        pauseOnFocus: true,
        arrows: false,
    });

    categorySlider.mount();

    // Main image slider
    var mainSlider = new Splide('.splideMain', {
        type: 'loop',
        autoplay: true,
        interval: 3000,
        pauseOnHover: true,
        pagination: false,
        arrows: false,
    });

    mainSlider.mount();
</script>
@endpush
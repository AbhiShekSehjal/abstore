@extends('layouts.main')

@section('title', 'Products')

@push('styles')
<style>
.products {
    overflow: hidden;
}

.productcard {
    border: none;
    border: 3px solid white;
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

.form-check-input[type=radio] {
    border-radius: 0;
}
</style>
@endpush

@section('content')

<div class="row">

    <div class="col-3 border-end rounded-5 pt-3 pe-3 ps-3">
        <b class='fs-4'>Filter</b>
        <hr>

        <p class='fs-4'>Products</p>

        @foreach($Categories as $category)
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="{{ $category->name }}" checked>
            <label class="form-check-label" for="{{ $category->name }}">
                {{ $category->name }}
            </label>
        </div>
        @endforeach

        <hr>

        <p class='fs-4'>Sort by</p>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="Discount" checked>
            <label class="form-check-label" for="Discount">Discount</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="Low Price" checked>
            <label class="form-check-label" for="Low Price">Low Price</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="High Price" checked>
            <label class="form-check-label" for="High Price">High Price</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="Trending" checked>
            <label class="form-check-label" for="Trending">Trending</label>
        </div>

        <hr>

        <p class='fs-4'>Price</p>

        <input type="range" class="form-range" min="0" max="10000" value="50" id="range4">
        <output for="range4" id="rangeValue" aria-hidden="true"></output>

        <hr>

        <button class='btn btn-dark rounded-0'>Show</button>
    </div>

    <div class="col-9 pe-0">
        <div class="products">
            <div class="row d-flex align-items-center justify-content-between flex-wrap">
                @foreach($products as $product)
                <div class="card rounded-0 col-lg-4 productcard">
                    <div class="productImage overflow-hidden">
                        <a href="product/{{ $product->id }}">
                            <img src="{{ $product->image }}" class="card-img-top" alt="Image of {{ $product->name }}">
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description}}</p>
                        <a href="#" class="btn btn-outline-dark rounded-0">Add to cart</a>
                        <a href="#" class="btn btn-success rounded-0">Buy Now</a>
                    </div>
                </div>
                @endforeach
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
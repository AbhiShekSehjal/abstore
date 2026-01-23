@extends('layouts.main')

@section('title', 'Cart')

@push('styles')
<style>
    .checkout-summary {
        position: fixed;
        top: 100px;
        width: 416px;
    }

    .related-products-section {
        margin-top: 40px;
        margin-bottom: 20px;
    }

    .related-products-scroll {
        display: flex;
        overflow-x: auto;
        gap: 15px;
        padding: 10px 0;
        scroll-behavior: smooth;
    }

    .related-products-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .related-products-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .related-products-scroll::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .related-products-scroll::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .related-product-card {
        flex: 0 0 280px;
        min-width: 280px;
    }

    .related-product-card .card {
        height: 100%;
    }

    /* Tablet */
    /* @media (min-width: 600px) {
        .checkout-summary{
            position: static;
            top: 0;left: 0;
        }
    } */
</style>
@endpush

@section('content')

<div class="container py-4">

    <div class="row">
        <!-- LEFT SIDE : CART ITEMS -->
        <div class="col-lg-8">
            <h1 class="mb-2 mt-2">Cart</h1>
            <p class="opacity-75">
                {{ $order?->items->count() ?? 0 }} items
            </p>

            <hr>

            @if($order && $order->items->count())
            @foreach($order->items as $item)
            <div class="row mb-4">

                <!-- IMAGE -->
                <div class="col-md-3">
                    <img src="{{ asset('storage/'.$item->product->image) }}"
                        class="img-fluid rounded-0">
                </div>

                <!-- PRODUCT DETAILS -->
                <div class="col-md-9 d-flex justify-content-between">
                    <div class="d-flex align-items-start justify-content-between flex-column">
                        <div>
                            <p class="fw-semibold mb-2">
                                <a href="/product/{{ $item->product->id }}" style="color: black; cursor: pointer; transition: color 0.2s ease;">{{ $item->product->name }}</a>
                            </p>

                            <p class="fw-bold text-secondary">
                                ₹ {{ number_format($item->product->sale_price, 2) }}
                            </p>
                        </div>

                        <!-- QUANTITY -->
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted">QTY:</span>

                            <button class="btn qty-btn rounded-0"
                                data-id="{{ $item->id }}"
                                data-action="decrease">−</button>

                            <span id="qty-{{ $item->id }}">{{ $item->quantity }}</span>

                            <button class="btn qty-btn rounded-0"
                                data-id="{{ $item->id }}"
                                data-action="increase">+</button>
                        </div>
                    </div>

                    <a href="javascript:void(0)"
                        class="text-dark fs-6 remove-item"
                        data-id="{{ $item->id }}">
                        Remove
                    </a>

                </div>
            </div>

            <hr>
            @endforeach

            <!-- RELATED PRODUCTS SECTION -->
            @if($order && $order->items->count())
            <div class="related-products-section">
                <h5 class="mb-3">You Might Also Like</h5>

                <div class="related-products-scroll">
                    @forelse($products as $product)
                    <div class="related-product-card">
                        <div class="card rounded-0 productcard h-100">
                            <div class="productImage overflow-hidden">
                                <a href="product/{{ $product->id }}">
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top rounded-0" style="object-fit: cover; height: 200px;">
                                    @else
                                    <img src="{{ asset('images/no-image.png') }}" class="card-img-top rounded-0" style="object-fit: cover; height: 200px;">
                                    @endif
                                </a>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title" style="font-size: 0.95rem;">{{ $product->name }}</h6>
                                <p class="card-text" style="font-size: 0.85rem; color: #666;">{{ Str::limit($product->description, 50) }}</p>
                                <p class="card-price mt-auto" style="margin-bottom: 10px;">
                                    <span class="fw-bold" style="font-size: 1rem;">₹{{ $product->sale_price }}</span>
                                    &nbsp;&nbsp;<del style="font-size: 0.85rem; color: #999;">₹{{ $product->price }}</del>
                                </p>
                                <p class="card-discount" style="font-size: 0.8rem; margin-bottom: 20px;">{{ $product->discount }}% off</p>

                                <div class="d-flex gap-2" style="flex-direction: column;">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-dark rounded-0 w-100" style="font-size: 0.85rem; padding: 6px;">
                                            Add to cart
                                        </button>
                                    </form>
                                    <a href="{{ route('buy.now', $product->id) }}" class="btn btn-success rounded-0 w-100" style="font-size: 0.85rem; padding: 6px;">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">No products available</p>
                    @endforelse
                </div>
            </div>
            @endif

            <!-- TRUST SIGNALS -->
            @if($order && $order->items->count())
            <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid #ddd;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">

                    <!-- Signal 1: Money Back Guarantee -->
                    <div style="text-align: center; padding: 20px;">
                        <div style="font-size: 2.5rem; margin-bottom: 10px; color: #000;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                            </svg>
                        </div>
                        <h6 style="font-weight: 700; color: #1a1a1a; margin-bottom: 5px;">100% Secure</h6>
                        <p style="font-size: 0.85rem; color: #666; margin: 0;">Your payment is protected</p>
                    </div>

                    <!-- Signal 2: Fast Delivery -->
                    <div style="text-align: center; padding: 20px;">
                        <div style="font-size: 2.5rem; margin-bottom: 10px; color: #000;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                                <path d="M0 6a6 6 0 1 1 12 0A6 6 0 0 1 0 6zm6-5a5 5 0 1 0 0 10A5 5 0 0 0 6 1zm.5 7H4V5.5h1V7z" fill="white" />
                            </svg>
                        </div>
                        <h6 style="font-weight: 700; color: #1a1a1a; margin-bottom: 5px;">Fast Delivery</h6>
                        <p style="font-size: 0.85rem; color: #666; margin: 0;">Get your order in 2-3 days</p>
                    </div>

                    <!-- Signal 3: Money Back Guarantee -->
                    <div style="text-align: center; padding: 20px;">
                        <div style="font-size: 2.5rem; margin-bottom: 10px; color: #000;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                            </svg>
                        </div>
                        <h6 style="font-weight: 700; color: #1a1a1a; margin-bottom: 5px;">30-Day Guarantee</h6>
                        <p style="font-size: 0.85rem; color: #666; margin: 0;">Full refund if not satisfied</p>
                    </div>

                </div>
            </div>
            @endif
            @else
            <div class="text-center my-5">
                <img src="https://res.cloudinary.com/djmmx0tri/image/upload/v1763708581/shopping_wsmji6.png" width="300">
                <p class="mt-3">Your cart is empty</p>
            </div>
            @endif
        </div>

        <!-- RIGHT SIDE : ORDER SUMMARY -->
        <div class="col-lg-4">
            <div class="border p-4 rounded-0 checkout-summary">

                <h5 class="fw-bold">
                    Order Summary ({{ $order?->items->count() ?? 0 }} items)
                </h5>

                @php
                $subtotal = $order?->items->sum(fn($i) => $i->product->sale_price * $i->quantity) ?? 0;
                @endphp

                <div class="d-flex justify-content-between">
                    <span>Sub-total</span>
                    <span>₹ {{ number_format($subtotal, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Shipping</span>
                    <span class="text-success">Free</span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Taxes</span>
                    <span class="opacity-75">* Taxes may apply</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Estimated Total</span>
                    <span>₹ {{ number_format($subtotal, 2) }}</span>
                </div>

                @if($order && $order->items->count())
                <a href="{{ route('checkout.index') }}">
                    <button class="btn btn-dark w-100 mt-4 py-3 rounded-0">
                        CHECKOUT
                    </button>
                </a>
                @else
                <button class="btn btn-dark w-100 mt-4 py-3 rounded-0" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
                    </svg>
                    CHECKOUT
                </button>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.qty-btn').forEach(button => {
        button.addEventListener('click', function() {

            let itemId = this.dataset.id;
            let action = this.dataset.action;

            fetch(`/cart/${action}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        item_id: itemId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('qty-' + itemId).innerText = data.quantity;
                    location.reload();
                });
        });
    });

    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {

            if (!confirm('Remove this item from cart?')) return;

            let itemId = this.dataset.id;

            fetch(`/cart/remove`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        item_id: itemId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    location.reload();
                });
        });
    });

    // Horizontal scroll for related products on mouse wheel
    const relatedProductsScroll = document.querySelector('.related-products-scroll');

    if (relatedProductsScroll) {
        relatedProductsScroll.addEventListener('wheel', function(e) {
            const isAtEnd = (this.scrollLeft + this.clientWidth >= this.scrollWidth - 10);
            const isAtStart = (this.scrollLeft <= 10);

            if ((e.deltaY > 0 && isAtEnd) || (e.deltaY < 0 && isAtStart)) {
                return;
            }

            e.preventDefault();

            this.scrollLeft += e.deltaY * 50;
        });
    }
</script>
@endpush
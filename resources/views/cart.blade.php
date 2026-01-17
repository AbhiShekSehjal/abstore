@extends('layouts.main')

@section('title', 'Cart')

@push('styles')
<style>
    .checkout-summary {
        position: fixed;
        top: 100px;
        width: 416px;
    }
</style>
@endpush

@section('content')

<div class="container py-4">

    <div class="row">
        <!-- LEFT SIDE : CART ITEMS -->
        <div class="col-lg-8">
            <h2 class="fw-bold">Cart</h2>
            <p class="text-muted">
                {{ $order?->items->count() ?? 0 }} items
            </p>

            <hr>

            @if($order && $order->items->count())
            @foreach($order->items as $item)
            <div class="row mb-4">

                <!-- IMAGE -->
                <div class="col-md-3">
                    <img src="{{ asset('storage/'.$item->product->image) }}"
                        class="img-fluid rounded">
                </div>

                <!-- PRODUCT DETAILS -->
                <div class="col-md-9 d-flex justify-content-between">
                    <div>

                        <h5 class="fw-semibold">
                            {{ $item->product->name }}
                        </h5>

                        <p class="mb-1 fw-bold">
                            ₹ {{ number_format($item->price, 2) }}
                        </p>

                        <!-- QUANTITY -->
                        <div class="d-flex align-items-center gap-2 my-2">
                            <span class="text-muted">QTY:</span>

                            <button class="btn btn-outline-dark btn-sm qty-btn rounded-0"
                                data-id="{{ $item->id }}"
                                data-action="decrease">−</button>

                            <span id="qty-{{ $item->id }}">{{ $item->quantity }}</span>

                            <button class="btn btn-outline-dark btn-sm qty-btn rounded-0"
                                data-id="{{ $item->id }}"
                                data-action="increase">+</button>
                        </div>
                    </div>


                    <!-- <a href="#" class="text-decoration-underline text-dark small">
                        View Customizations
                    </a> -->
                    <a href="javascript:void(0)"
                        class="text-dark fs-6 remove-item"
                        data-id="{{ $item->id }}">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                        </svg> -->
                        Remove
                    </a>

                </div>

                <!-- REMOVE -->

            </div>

            <hr>
            @endforeach
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

                <!-- <p class="text-success fw-semibold">
                    ✔ Congrats! You qualify for free standard shipping.
                </p> -->

                <!-- <hr> -->

                <h5 class="fw-bold">
                    Order Summary ({{ $order?->items->count() ?? 0 }} items)
                </h5>

                @php
                $subtotal = $order?->items->sum(fn($i) => $i->price * $i->quantity) ?? 0;
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
                    <span class="text-muted">* Taxes may apply</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Estimated Total</span>
                    <span>₹ {{ number_format($subtotal, 2) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}">
                    <button class="btn btn-dark w-100 mt-4 py-3 rounded-0">
                        CHECKOUT
                    </button>
                </a>
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
</script>
@endpush
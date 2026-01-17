@extends('layouts.main')
@section('title', 'Checkout')

@push('styles')
<style>
    .checkout-summary {
        position: fixed;
        top: 100px;
        width: 416px;
    }

    .payment-card {
        display: block;
        border: 2px solid #ddd;
        border-radius: 8px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: 0.2s;
    }

    .payment-card .card-inner {
        padding: 15px;
    }

    .payment-card:hover {
        border-color: grey;
    }

    .payment-card.active {
        border: 2px solid grey;
        background: #faf7ff;
    }

    .radio-dot {
        width: 19px;
        height: 19px;
        border-radius: 50%;
        border: 2px solid #6f42c1;
        position: relative;
    }

    .radio-dot::after {
        content: '';
        width: 10px;
        height: 10px;
        background: #6f42c1;
        border-radius: 50%;
        position: absolute;
        top: 3px;
        left: 3px;
        opacity: 0;
    }

    .payment-card.active .radio-dot::after {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <div class="row g-4">

        <!-- LEFT : ADDRESS FORM -->
        <div class="col-lg-8">
            <div class="card rounded-0 shadow-sm">

                <div class="card-body">
                    <h6 class="fw-bold mb-3">Shipping Address</h6>
                    <form id="checkoutForm" method="POST" action="">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="name">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control rounded-0" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control rounded-0" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control rounded-0" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="address">Address</label>
                                <textarea name="address" rows="3" id="address" class="form-control rounded-0" required></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="city">City</label>
                                <input type="text" name="city" id="city" class="form-control rounded-0" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="state">State</label>
                                <input type="text" name="state" id="state" class="form-control rounded-0" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="pincode">Pincode</label>
                                <input type="text" name="pincode" id="pincode" class="form-control rounded-0" required>
                            </div>

                            <hr class="my-3">

                            <!-- PAYMENT METHOD -->
                            <h6 class="fw-bold mb-3">Payment Method</h6>

                            <div class="payment-box">

                                <!-- COD -->
                                <label class="payment-card">
                                    <input type="radio" name="payment_method" value="cod" class="payment d-none">

                                    <div class="card-inner">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Cash on Delivery</strong>
                                            </div>
                                            <span class="radio-dot"></span>
                                        </div>
                                    </div>
                                </label>

                                <label class="payment-card">
                                    <input type="radio" name="payment_method" value="online" class="payment d-none">

                                    <div class="card-inner">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Pay Online</strong>
                                            </div>
                                            <span class="radio-dot"></span>
                                        </div>

                                        <div class="qr-box d-none mt-3 text-center">
                                            <img src="{{ asset('images/qr.png') }}" width="160">
                                        </div>
                                    </div>
                                </label>


                            </div>


                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- RIGHT : ORDER SUMMARY -->
        <div class="col-lg-4">
            <div class="border p-4 rounded-0 checkout-summary">

                <h5 class="fw-bold">
                    Order Summary ({{ $order?->items->count() ?? 0 }} items)
                </h5>

                @php
                $subtotal = $order?->items->sum(fn($i) => $i->price * $i->quantity) ?? 0;
                @endphp

                @foreach($order->items as $item)
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                    <span>₹{{ $item->quantity * $item->price }}</span>
                </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Estimated Total</span>
                    <span>₹ {{ number_format($subtotal, 2) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}">
                    <button class="btn btn-dark w-100 mt-4 py-3 rounded-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
                        </svg> Continue
                    </button>
                </a>
            </div>
        </div>

    </div>
</div>

<!-- JS -->
<script>
    document.querySelectorAll('.payment').forEach(el => {
        el.addEventListener('change', function() {
            document.getElementById('qrBox').classList.toggle('d-none', this.value !== 'online');
        });
    });

    document.querySelectorAll('.payment-card').forEach(card => {
        card.addEventListener('click', function() {

            document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('active'));

            this.classList.add('active');

            this.querySelector('input').checked = true;

            document.querySelectorAll('.qr-box').forEach(q => q.classList.add('d-none'));

            if (this.querySelector('input').value === 'online') {
                this.querySelector('.qr-box').classList.remove('d-none');
            }
        });
    });
</script>
@endsection
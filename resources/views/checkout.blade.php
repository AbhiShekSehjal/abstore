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

    .alert-message {
        border-radius: 8px;
        margin-bottom: 20px;
        padding: 15px 20px;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 5px;
        display: block;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background-color: #fff5f5;
    }

    .form-control.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        background-color: #fff5f5;
    }

    .form-control {
        transition: all 0.2s ease;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.15);
    }

    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }

    .form-text {
        font-size: 0.8rem;
        margin-top: 4px;
        display: block;
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <div class="row g-4">

        <!-- LEFT : ADDRESS FORM -->
        <div class="col-lg-8">

            <!-- Success Message -->
            @if (session('success'))
            <div class="alert alert-success alert-message" role="alert">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
            <div class="alert alert-danger alert-message" role="alert">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-circle-fill me-2" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
            @endif

            <div class="card rounded-0 shadow-sm">

                <div class="card-body">
                    <h6 class="fw-bold mb-3">Shipping Address</h6>
                    <form id="checkoutForm" method="POST" action="{{ route('checkout.store') }}" novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="name">Full Name <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control rounded-0 @error('name') is-invalid @enderror"
                                    value="{{ old('name') ?? ($lastOrder ? $lastOrder->name : '') }}"
                                    placeholder="Enter your full name"
                                    pattern="[a-zA-Z\s]{2,}"
                                    required>
                                <small class="form-text text-muted">Only letters and spaces allowed</small>
                                @error('name')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="phone">Phone <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        class="form-control rounded-0 @error('phone') is-invalid @enderror"
                                        value="{{ old('phone') ?? ($lastOrder ? $lastOrder->phone : '') }}"
                                        placeholder="Enter 10-digit mobile number"
                                        maxlength="10"
                                        pattern="[0-9]{10}"
                                        inputmode="numeric"
                                        required>
                                    <small id="phoneHint" class="form-text text-muted d-block">
                                        <span id="phoneCount">0</span>/10 digits
                                    </small>
                                </div>
                                @error('phone')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="email">Email Address <span class="text-danger">*</span></label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control rounded-0 @error('email') is-invalid @enderror"
                                    value="{{ old('email') ?? ($lastOrder ? $lastOrder->email : '') }}"
                                    placeholder="example@email.com"
                                    required>
                                <small class="form-text text-muted">We'll send order updates to this email</small>
                                @error('email')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="address">Delivery Address <span class="text-danger">*</span></label>
                                <textarea
                                    name="address"
                                    rows="3"
                                    id="address"
                                    class="form-control rounded-0 @error('address') is-invalid @enderror"
                                    placeholder="Enter your complete delivery address (House/Building name, Street, Area)"
                                    required>{{ old('address') ?? ($lastOrder ? $lastOrder->address : '') }}</textarea>
                                <small class="form-text text-muted">Include house/building name, street, and area details</small>
                                @error('address')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="city">City/Town <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="city"
                                    id="city"
                                    class="form-control rounded-0 @error('city') is-invalid @enderror"
                                    value="{{ old('city') ?? ($lastOrder ? $lastOrder->city : '') }}"
                                    placeholder="e.g., Mumbai, Delhi, Bangalore"
                                    required>
                                @error('city')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="state">State/Union Territory <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="state"
                                    id="state"
                                    class="form-control rounded-0 @error('state') is-invalid @enderror"
                                    value="{{ old('state') ?? ($lastOrder ? $lastOrder->state : '') }}"
                                    placeholder="e.g., Maharashtra, Delhi, Karnataka"
                                    required>
                                @error('state')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="pincode">Pincode <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input
                                        type="text"
                                        name="pincode"
                                        id="pincode"
                                        class="form-control rounded-0 @error('pincode') is-invalid @enderror"
                                        value="{{ old('pincode') ?? ($lastOrder ? $lastOrder->pincode : '') }}"
                                        placeholder="6-digit postal code"
                                        maxlength="6"
                                        pattern="[0-9]{6}"
                                        inputmode="numeric"
                                        required>
                                    <small id="pincodeHint" class="form-text text-muted d-block">
                                        <span id="pincodeCount">0</span>/6 digits
                                    </small>
                                </div>
                                @error('pincode')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <hr class="my-3">

                            <!-- PAYMENT METHOD -->
                            <h6 class="fw-bold mb-3">Payment Method <span class="text-danger">*</span></h6>

                            @error('payment_method')
                            <div class="col-md-12 mb-2">
                                <span class="error-message">{{ $message }}</span>
                            </div>
                            @enderror

                            <div class="payment-box w-100">

                                <!-- COD -->
                                <label class="payment-card">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="cod"
                                        class="payment d-none"
                                        {{ old('payment_method') === 'cod' ? 'checked' : '' }}>

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
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="online"
                                        class="payment d-none"
                                        {{ old('payment_method') === 'online' ? 'checked' : '' }}>

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
                    <span>₹{{ number_format($item->quantity * $item->price, 2) }}</span>
                </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Estimated Total</span>
                    <span>₹ {{ number_format($subtotal, 2) }}</span>
                </div>

                <button
                    type="submit"
                    form="checkoutForm"
                    id="placeOrderBtn"
                    class="btn btn-dark w-100 mt-4 py-3 rounded-0"
                    disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock me-2" viewBox="0 0 16 16" id="btnLockIcon">
                        <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
                    </svg> <span id="btnText">Place Order</span>
                </button>
            </div>
        </div>

    </div>
</div>

<!-- JS -->
<script>
    document.querySelectorAll('.payment').forEach(el => {
        el.addEventListener('change', function() {
            document.querySelectorAll('.qr-box').forEach(q => q.classList.add('d-none'));
            if (this.value === 'online') {
                this.closest('.payment-card').querySelector('.qr-box').classList.remove('d-none');
            }
            validateForm();
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
            validateForm();
        });
    });

    // Initialize active payment card on page load
    document.addEventListener('DOMContentLoaded', function() {
        const activePayment = document.querySelector('.payment:checked');
        if (activePayment) {
            activePayment.closest('.payment-card').classList.add('active');
            if (activePayment.value === 'online') {
                activePayment.closest('.payment-card').querySelector('.qr-box').classList.remove('d-none');
            }
        }

        // Add event listeners to all form inputs for real-time validation
        const form = document.getElementById('checkoutForm');
        const inputs = form.querySelectorAll('input[type="text"], input[type="email"], textarea');
        const paymentRadios = form.querySelectorAll('input[name="payment_method"]');
        const phoneInput = document.getElementById('phone');
        const pincodeInput = document.getElementById('pincode');

        inputs.forEach(input => {
            input.addEventListener('input', validateForm);
            input.addEventListener('change', validateForm);
        });

        // Update phone counter
        phoneInput.addEventListener('input', function() {
            document.getElementById('phoneCount').textContent = this.value.length;
        });

        // Update pincode counter
        pincodeInput.addEventListener('input', function() {
            document.getElementById('pincodeCount').textContent = this.value.length;
        });

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', validateForm);
        });

        // Form submission validation
        form.addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                e.preventDefault();
                alert('Please select a payment method');
            }
        });

        // Initial validation check
        validateForm();
    });

    // Validation function
    function validateForm() {
        const form = document.getElementById('checkoutForm');
        const btn = document.getElementById('placeOrderBtn');
        const lockIcon = document.getElementById('btnLockIcon');

        // Get all required fields
        const nameInput = document.getElementById('name');
        const phoneInput = document.getElementById('phone');
        const emailInput = document.getElementById('email');
        const addressInput = document.getElementById('address');
        const cityInput = document.getElementById('city');
        const stateInput = document.getElementById('state');
        const pincodeInput = document.getElementById('pincode');
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');

        // Validation rules
        const isNameValid = nameInput.value.trim().length >= 2 && /^[a-zA-Z\s]+$/.test(nameInput.value.trim());
        const isPhoneValid = /^[0-9]{10}$/.test(phoneInput.value.trim());
        const isEmailValid = emailInput.value.trim().length > 0 && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
        const isAddressValid = addressInput.value.trim().length >= 10;
        const isCityValid = cityInput.value.trim().length >= 2;
        const isStateValid = stateInput.value.trim().length >= 2;
        const isPincodeValid = /^[0-9]{6}$/.test(pincodeInput.value.trim());
        const isPaymentSelected = paymentMethod !== null;

        // Determine if form is valid
        const isFormValid = isNameValid && isPhoneValid && isEmailValid && isAddressValid &&
            isCityValid && isStateValid && isPincodeValid && isPaymentSelected;

        // Update button state
        if (isFormValid) {
            btn.disabled = false;
            lockIcon.style.display = 'none';
        } else {
            btn.disabled = true;
            lockIcon.style.display = 'inline';
        }

        // Also add/remove error classes for visual feedback
        phoneInput.classList.toggle('is-invalid', !isPhoneValid && phoneInput.value.trim().length > 0);
        pincodeInput.classList.toggle('is-invalid', !isPincodeValid && pincodeInput.value.trim().length > 0);
        nameInput.classList.toggle('is-invalid', !isNameValid && nameInput.value.trim().length > 0);
        addressInput.classList.toggle('is-invalid', !isAddressValid && addressInput.value.trim().length > 0);
    }
</script>
@endsection
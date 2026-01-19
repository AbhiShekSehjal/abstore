@extends('layouts.main')

@section('title', 'Track Your Orders')

@push('styles')
<style>
    .order-card {
        border: 1px solid #e0e0e0;
        margin-bottom: 24px;
    }

    .order-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #f0f1f3 100%);
        padding: 20px 24px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-id {
        font-weight: 700;
        color: #1a1a1a;
        font-size: 1.1rem;
        margin-bottom: 6px;
    }

    .order-date {
        color: #666;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
    }

    .order-date svg {
        margin-right: 6px;
    }

    .order-status {
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-confirmed {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .status-shipped {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-delivered {
        background-color: #c3e6cb;
        color: #155724;
        border: 1px solid #b1dfbb;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .order-body {
        padding: 24px;
    }

    .section-title {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
        font-size: 1rem;
        display: flex;
        align-items: center;
    }

    .section-title svg {
        margin-right: 8px;
    }

    .address-info {
        background: linear-gradient(135deg, #f8f9fa 0%, #f5f6f8 100%);
        padding: 20px;
        border-radius: 20px;
        margin-bottom: 20px;
        border-left: 4px solid #6f42c1;
    }

    .address-info h6 {
        margin-bottom: 12px;
        color: #1a1a1a;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .address-detail {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 6px;
        line-height: 1.5;
    }

    .address-detail strong {
        color: #1a1a1a;
        font-weight: 600;
    }

    .items-table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .items-table thead {
        background: linear-gradient(135deg, #f8f9fa 0%, #f0f1f3 100%);
    }

    .items-table th {
        padding: 14px 16px;
        text-align: left;
        font-weight: 700;
        color: #1a1a1a;
        border-bottom: 2px solid #e0e0e0;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .items-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f0f0f0;
        color: #555;
        font-size: 0.9rem;
    }

    .items-table tbody tr:hover {
        background-color: #fafafa;
    }

    .items-table tbody tr:last-child td {
        border-bottom: none;
    }

    .product-name {
        font-weight: 600;
        color: #007bff;
        text-decoration: none;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .product-name:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    .order-footer {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        padding-top: 20px;
        border-top: 1px solid #e0e0e0;
    }

    .footer-section {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .footer-label {
        color: #666;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .payment-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .payment-method {
        font-weight: 600;
        color: #1a1a1a;
    }

    .payment-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        width: fit-content;
        border: 1px solid transparent;
    }

    .payment-pending {
        background-color: #fff3cd;
        color: #856404;
        border-color: #ffeaa7;
    }

    .payment-paid {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }

    .payment-failed {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }

    .order-total {
        font-size: 1.4rem;
        font-weight: 700;
        color: #6f42c1;
        text-align: right;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state svg {
        color: #ddd;
        margin-bottom: 24px;
        opacity: 0.6;
    }

    .empty-state h4 {
        color: #555;
        margin-bottom: 12px;
        font-weight: 700;
        font-size: 1.4rem;
    }

    .empty-state p {
        color: #999;
        margin-bottom: 28px;
        font-size: 1rem;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
    }

    .btn-back {
        mix-blend-mode: difference;
        background-blend-mode: difference;
        background-color: white;
    }

    .order-meta {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 8px;
        align-items: center;
    }

    .order-timeline {
        padding: 24px;
        border-bottom: 1px solid #e0e0e0;
        background: #fafafa;
    }

    .timeline-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
    }

    .timeline-step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f0f0f0;
        border: 2px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #999;
        font-size: 0.8rem;
        margin-bottom: 8px;
        z-index: 2;
        position: relative;
    }

    .timeline-step.active .timeline-step-circle {
        background: #28a745;
        border-color: #28a745;
        color: white;
    }

    .timeline-step.current .timeline-step-circle {
        background: #007bff;
        border-color: #007bff;
        color: white;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .timeline-step-label {
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
        color: #666;
        max-width: 80px;
    }

    .timeline-step.active .timeline-step-label {
        color: #28a745;
    }

    .timeline-step.current .timeline-step-label {
        color: #007bff;
    }

    .timeline-connector {
        position: absolute;
        height: 2px;
        background: #ddd;
        top: 20px;
        z-index: 1;
    }

    .timeline-connector.active {
        background: #28a745;
    }

    .edit-address-btn {
        padding: 8px 16px;
        background: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        margin-top: 12px;
        transition: background 0.2s ease;
    }

    .edit-address-btn:hover {
        background: #0056b3;
    }

    .edit-address-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .order-footer {
            grid-template-columns: 1fr;
        }

        .order-total {
            text-align: left;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-4">

    <!-- Success Message -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; border-left: 4px solid #28a745;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>
        <strong>Order Placed Successfully!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="text-center mb-2 mt-2">Track Your Orders</h1>
        <a href="{{ route('products') }}" class="btn-back btn btn-outline-dark rounded-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
            </svg>
            Continue Shopping
        </a>
    </div>

    @if($orders->isEmpty())
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-bag-check" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
            <path d="M1 5.5A.5.5 0 0 1 1.5 5h1.063V4a2 2 0 0 1 4.941 0v1h1.063a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5H1.5a.5.5 0 0 1-.5-.5v-9zm2 1V4a1 1 0 0 1 1.906-.755.5.5 0 1 0 .882.369A2 2 0 0 0 3 4v2.5z" />
        </svg>
        <h1>No Orders Yet</h1>
        <p>You haven't placed any orders yet. Start shopping now!</p>
    </div>
    @else
    @foreach($orders as $order)
    @if($order->order_status !== 'cart')
    <div class="order-card">
        <!-- Order Header -->
        <div class="order-header">
            <div class="order-meta">
                <div>
                    <div class="order-id">
                        Order #{{ $order->id }}
                    </div>
                    <div class="order-date">
                        {{ $order->created_at->setTimezone('Asia/Kolkata')->format('d M Y') }} at {{ $order->created_at->setTimezone('Asia/Kolkata')->format('h:i A') }}
                    </div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <span class="order-status status-{{ $order->order_status }}">
                    {{ ucfirst($order->order_status) }}
                </span>
                @if(in_array($order->order_status, ['pending', 'confirmed']))
                <form method="POST" action="{{ route('orders.cancel', $order->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm" style="padding: 8px 16px; font-size: 0.9rem; font-weight: 600; border-radius: 4px;" onclick="return confirm('Are you sure you want to cancel this order? This action cannot be undone.')">
                        ✕ Cancel Order
                    </button>
                </form>
                @endif
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="order-timeline">
            <div class="timeline-steps">
                @php
                $statuses = ['pending' => 'Order Placed', 'confirmed' => 'Confirmed', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
                $statusOrder = ['pending', 'confirmed', 'shipped', 'delivered'];
                $currentIndex = array_search($order->order_status, $statusOrder);
                if ($currentIndex === false) $currentIndex = 0;
                @endphp

                @foreach($statusOrder as $index => $status)
                <div class="timeline-step {{ $index < $currentIndex ? 'active' : ($index == $currentIndex ? 'current' : '') }}">
                    <div class="timeline-step-circle">
                        @if($index < $currentIndex)
                            ✓
                            @else
                            {{ $index + 1 }}
                            @endif
                            </div>
                            <div class="timeline-step-label">{{ $statuses[$status] }}</div>
                    </div>

                    @if($index < count($statusOrder) - 1)
                        <div class="timeline-connector {{ $index < $currentIndex ? 'active' : '' }}" style="width: calc(100% - 120px); left: 60px;">
                </div>
                @endif
                @endforeach
            </div>
        </div>

        <!-- Order Body -->
        <div class="order-body">
            <!-- Edit Address Modal -->
            <div class="modal fade" id="editAddressModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content rounded-0">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Delivery Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('orders.updateAddress', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Full Name</strong></label>
                                    <input type="text" class="form-control rounded-0" name="name" value="{{ $order->name }}" required>
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Phone Number</strong></label>
                                        <input type="text" class="form-control rounded-0" name="phone" value="{{ $order->phone }}" maxlength="10" pattern="[0-9]{10}" required>
                                        @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Email</strong></label>
                                        <input type="email" class="form-control rounded-0" name="email" value="{{ $order->email }}" required>
                                        @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Address</strong></label>
                                    <input type="text" class="form-control rounded-0" name="address" value="{{ $order->address }}" required>
                                    @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>City</strong></label>
                                        <input type="text" class="form-control rounded-0" name="city" value="{{ $order->city }}" required>
                                        @error('city')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>State</strong></label>
                                        <input type="text" class="form-control rounded-0" name="state" value="{{ $order->state }}" required>
                                        @error('state')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>PIN Code</strong></label>
                                    <input type="text" class="form-control rounded-0" name="pincode" value="{{ $order->pincode }}" maxlength="6" pattern="[0-9]{6}" required>
                                    @error('pincode')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded-0">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Accordion Container for Feedback and Order Items (Only for Delivered Orders) -->
            @if($order->order_status === 'delivered')
            <div class="accordion" id="orderAccordion-{{ $order->id }}" style="margin-top: 20px;">

                <!-- FEEDBACK ACCORDION PANEL (First) -->
                <div class="accordion-item rounded-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#feedbackPanel-{{ $order->id }}" aria-expanded="true" aria-controls="feedbackPanel-{{ $order->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill me-2" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            Feedback
                        </button>
                    </h2>
                    <div id="feedbackPanel-{{ $order->id }}" class="accordion-collapse collapse show" data-bs-parent="#orderAccordion-{{ $order->id }}">
                        <div class="accordion-body">
                            @if(!$order->feedback)
                            <!-- Feedback Form (Only for delivered orders without feedback) -->
                            <div style="padding: 20px 0;">
                                <p style="color: #666; margin-bottom: 20px; font-size: 0.9rem;">We'd love to hear about your experience with this order!</p>

                                <form action="{{ route('orders.submitFeedback', $order->id) }}" method="POST">
                                    @csrf

                                    <!-- Rating Stars -->
                                    <div style="margin-bottom: 20px;">
                                        <label style="font-weight: 600; color: #1a1a1a; margin-bottom: 10px; display: block;">How would you rate this order? <span style="color: #dc3545;">*</span></label>
                                        <div style="display: flex; gap: 10px; align-items: center;" class="rating-stars-{{ $order->id }}">
                                            @for($i = 1; $i <= 5; $i++)
                                                <label style="cursor: pointer; font-size: 2rem; transition: all 0.2s ease;">
                                                <input type="radio" name="rating" value="{{ $i }}" style="display: none;" required data-order-id="{{ $order->id }}">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#ddd" class="star-icon" data-star="{{ $i }}" viewBox="0 0 16 16" style="transition: all 0.2s ease;">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>

                                                </label>
                                                @endfor
                                        </div>
                                        @error('rating')
                                        <small style="color: #dc3545;">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <script>
                                        (function() {
                                            const orderId = '{{ $order->id }}';
                                            const starsContainer = document.querySelector('.rating-stars-' + orderId);
                                            const starIcons = starsContainer.querySelectorAll('.star-icon');
                                            const ratingInputs = starsContainer.querySelectorAll('input[type="radio"]');

                                            // Function to update star colors
                                            function updateStars(selectedValue) {
                                                starIcons.forEach((star, index) => {
                                                    const starNumber = index + 1;
                                                    if (starNumber <= selectedValue) {
                                                        star.style.fill = '#ffc107';
                                                    } else {
                                                        star.style.fill = '#ddd';
                                                    }
                                                });
                                            }

                                            // Add hover effect
                                            starIcons.forEach((star, index) => {
                                                star.addEventListener('mouseover', function() {
                                                    starIcons.forEach((s, i) => {
                                                        if (i <= index) {
                                                            s.style.fill = '#ffc107';
                                                        } else {
                                                            s.style.fill = '#ddd';
                                                        }
                                                    });
                                                });
                                            });

                                            // Reset to selected value on mouse out
                                            starsContainer.addEventListener('mouseout', function() {
                                                const checked = starsContainer.querySelector('input[type="radio"]:checked');
                                                if (checked) {
                                                    updateStars(checked.value);
                                                } else {
                                                    starIcons.forEach(star => star.style.fill = '#ddd');
                                                }
                                            });

                                            // Update on click/change
                                            ratingInputs.forEach(input => {
                                                input.addEventListener('change', function() {
                                                    updateStars(this.value);
                                                });
                                            });

                                            // Initialize if there's a pre-selected value
                                            const checked = starsContainer.querySelector('input[type="radio"]:checked');
                                            if (checked) {
                                                updateStars(checked.value);
                                            }
                                        })();
                                    </script>

                                    <!-- Feedback Text -->
                                    <div style="margin-bottom: 20px;">
                                        <label style="font-weight: 600; color: #1a1a1a; margin-bottom: 10px; display: block;">Tell us about your experience <span style="color: #dc3545;">*</span></label>
                                        <textarea name="feedback" placeholder="Share your experience with this product and our service..." style="width: 100%; padding: 12px; border: 1px solid #ddd; font-size: 0.9rem; font-family: inherit; min-height: 100px; resize: vertical;" required maxlength="1000">{{ old('feedback') }}</textarea>
                                        <small style="color: #999;">Minimum 10 characters, maximum 1000 characters</small>
                                        @error('feedback')
                                        <small style="color: #dc3545; display: block; margin-top: 5px;">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" style="background: #1a1a1a; color: white; border: none; padding: 12px 30px; font-weight: 600; cursor: pointer; width: 100%; transition: background 0.2s ease;">
                                        Submit Feedback
                                    </button>
                                </form>
                            </div>
                            @elseif($order->feedback)
                            <!-- Feedback Already Submitted -->
                            <div style="padding: 20px 0;">
                                <h6 style="font-weight: 700; color: #2e7d32; margin-bottom: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16" style="vertical-align: middle;">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </svg>
                                    Thank You for Your Feedback!
                                </h6>
                                <p style="color: #2e7d32; margin: 0; font-size: 0.9rem;">Your rating: <strong>{{ $order->rating }}/5 ⭐</strong></p>
                                <p style="color: #555; margin-top: 10px; font-style: italic;">{{ $order->feedback }}</p>
                            </div>
                            @else
                            <p style="color: #999; padding: 20px 0; margin: 0;">Thank you for your order. Feedback will be available once your order is delivered.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- PRODUCT SUMMARY ACCORDION PANEL (Second) -->
                <div class="accordion-item rounded-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed d-flex align-items-center gap-2 rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#productsPanel-{{ $order->id }}" aria-expanded="false" aria-controls="productsPanel-{{ $order->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z" />
                            </svg>
                            Order Summary
                        </button>
                    </h2>
                    <div id="productsPanel-{{ $order->id }}" class="accordion-collapse collapse" data-bs-parent="#orderAccordion-{{ $order->id }}">
                        <div class="accordion-body">
                            <!-- Delivery Address -->
                            <div class="address-info" style="margin-bottom: 30px;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div style="flex: 1;">
                                        <h6 class="section-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                                            </svg>
                                            Delivery Address
                                        </h6>
                                        <div class="address-detail"><strong>{{ $order->name }}</strong></div>
                                        <div class="address-detail">{{ $order->address }}</div>
                                        <div class="address-detail">{{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</div>
                                        <div class="address-detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16" style="margin-right: 4px;">
                                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.458a.45.45 0 0 0 .087.529l.46.46a.45.45 0 0 0 .529.087l2.458-.547c.52-.13 1.071-.014 1.494.315l2.306 1.794c.745.578 1.076 1.55.63 2.415-.163.397-.632.643-1.228.643h-.308c-1.967 0-5.77-1.416-7.908-3.553-2.137-2.137-3.553-5.941-3.553-7.908V1.77c0-.596.246-1.065.643-1.228.865-.446 1.837-.115 2.415.63l.011.012z" />
                                            </svg>
                                            {{ $order->phone }}
                                        </div>
                                        <div class="address-detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16" style="margin-right: 4px;">
                                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Z" />
                                            </svg>
                                            {{ $order->email }}
                                        </div>
                                    </div>
                                    @if(in_array($order->order_status, ['pending', 'confirmed']))
                                    <button class="btn btn-outline-dark rounded-0 py-0" type="button" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $order->id }}" style="margin-left: 20px; height: fit-content;">
                                        Edit
                                    </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Order Items Table -->
                            <table class="items-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th style="text-align: center;">Qty</th>
                                        <th style="text-align: right;">Price</th>
                                        <th style="text-align: right;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $subtotal = 0;
                                    @endphp
                                    @foreach($order->items as $item)
                                    @php
                                    $itemTotal = $item->price * $item->quantity;
                                    $subtotal += $itemTotal;
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="/product/{{ $item->product->id }}" class="product-name" target="_blank">{{ $item->product->name }}</a>
                                        </td>
                                        <td style="text-align: center; font-weight: 600;">{{ $item->quantity }}</td>
                                        <td style="text-align: right;">₹{{ number_format($item->price, 2) }}</td>
                                        <td style="text-align: right; font-weight: 700; color: #1a1a1a;">₹{{ number_format($itemTotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Order Footer -->
                            <div class="order-footer" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px;">
                                <div class="footer-section">
                                    <div class="footer-label">Payment Information</div>
                                    <div class="payment-info">
                                        <div>
                                            <span style="color: #666; font-size: 0.85rem;">Method:</span>
                                            <div class="payment-method">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-credit-card-2-front-fill" viewBox="0 0 16 16" style="margin-right: 6px; vertical-align: middle;">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-11z" />
                                                </svg>
                                                {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}
                                            </div>
                                        </div>
                                        <span class="payment-badge payment-{{ $order->payment_status }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="footer-section" style="align-items: flex-end;">
                                    <div class="footer-label">Order Total</div>
                                    <div class="order-total">
                                        ₹{{ number_format($subtotal, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @else
            <!-- PLAIN ORDER SUMMARY (For Non-Delivered Orders) -->
            <div style="margin-top: 20px;">
                <!-- Delivery Address -->
                <div class="address-info" style="margin-bottom: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div style="flex: 1;">
                            <h6 class="section-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                                </svg>
                                Delivery Address
                            </h6>
                            <div class="address-detail"><strong>{{ $order->name }}</strong></div>
                            <div class="address-detail">{{ $order->address }}</div>
                            <div class="address-detail">{{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</div>
                            <div class="address-detail">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16" style="margin-right: 4px;">
                                    <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.458a.45.45 0 0 0 .087.529l.46.46a.45.45 0 0 0 .529.087l2.458-.547c.52-.13 1.071-.014 1.494.315l2.306 1.794c.745.578 1.076 1.55.63 2.415-.163.397-.632.643-1.228.643h-.308c-1.967 0-5.77-1.416-7.908-3.553-2.137-2.137-3.553-5.941-3.553-7.908V1.77c0-.596.246-1.065.643-1.228.865-.446 1.837-.115 2.415.63l.011.012z" />
                                </svg>
                                {{ $order->phone }}
                            </div>
                            <div class="address-detail">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16" style="margin-right: 4px;">
                                    <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Z" />
                                </svg>
                                {{ $order->email }}
                            </div>
                        </div>
                        @if(in_array($order->order_status, ['pending', 'confirmed']))
                        <button class="btn btn-outline-dark rounded-0 py-0" type="button" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $order->id }}" style="margin-left: 20px; height: fit-content;">
                            Edit
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Order Items Table -->
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Price</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $subtotal = 0;
                        @endphp
                        @foreach($order->items as $item)
                        @php
                        $itemTotal = $item->price * $item->quantity;
                        $subtotal += $itemTotal;
                        @endphp
                        <tr>
                            <td>
                                <a href="/product/{{ $item->product->id }}" class="product-name" target="_blank">{{ $item->product->name }}</a>
                            </td>
                            <td style="text-align: center; font-weight: 600;">{{ $item->quantity }}</td>
                            <td style="text-align: right;">₹{{ number_format($item->price, 2) }}</td>
                            <td style="text-align: right; font-weight: 700; color: #1a1a1a;">₹{{ number_format($itemTotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Order Footer -->
                <div class="order-footer" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px;">
                    <div class="footer-section">
                        <div class="footer-label">Payment Information</div>
                        <div class="payment-info">
                            <div>
                                <span style="color: #666; font-size: 0.85rem;">Method:</span>
                                <div class="payment-method">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-credit-card-2-front-fill" viewBox="0 0 16 16" style="margin-right: 6px; vertical-align: middle;">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-11z" />
                                    </svg>
                                    {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}
                                </div>
                            </div>
                            <span class="payment-badge payment-{{ $order->payment_status }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                    <div class="footer-section" style="align-items: flex-end;">
                        <div class="footer-label">Order Total</div>
                        <div class="order-total">
                            ₹{{ number_format($subtotal, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>



    @endif
    @endforeach

    <div style="margin-top: 50px; padding-top: 30px;">
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

</div>

@endsection
@extends('layouts.admin.main')

@section('title', 'Orders')

<!-- @push('styles')
<style>
    
</style>
@endpush -->

@push('styles')
<style>
    /* Responsive Media Queries */
    @media (max-width: 991px) {
        .d-flex.align-items-center.justify-content-between {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .d-flex.align-items-start > h1 {
            font-size: 1.5rem;
        }

        .container.py-4 {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }

        .row.g-3 {
            flex-direction: column;
        }

        .row.g-3 > div {
            width: 100% !important;
        }

        .form-control,
        .form-select,
        .btn {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        table {
            font-size: 0.75rem;
        }

        table thead th {
            padding: 0.5rem 0.25rem;
        }

        table tbody td {
            padding: 0.5rem 0.25rem;
        }

        .btn-sm {
            font-size: 0.65rem;
            padding: 0.35rem 0.5rem;
        }

        .d-flex.gap-2 {
            flex-direction: column;
            gap: 0.5rem !important;
        }

        .modal-dialog {
            margin: 1rem;
        }

        .collapse {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 767px) {
        .container.py-4 {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }

        h1 {
            font-size: 1.25rem !important;
        }

        h6 {
            font-size: 0.9rem;
        }

        table {
            font-size: 0.65rem;
        }

        table thead th {
            padding: 0.35rem 0.15rem !important;
        }

        table tbody td {
            padding: 0.35rem 0.15rem !important;
        }

        .btn-sm {
            font-size: 0.6rem;
            padding: 0.3rem 0.4rem;
        }

        .badge {
            font-size: 0.7rem;
        }

        .form-control,
        .form-select,
        .btn {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }

        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .collapse {
            font-size: 0.75rem;
        }

        .table-sm {
            font-size: 0.65rem;
        }
    }

    @media (max-width: 576px) {
        .container.py-4 {
            padding: 0.5rem !important;
        }

        h1 {
            font-size: 1.1rem !important;
        }

        h6 {
            font-size: 0.85rem;
        }

        table {
            font-size: 0.6rem;
        }

        table thead th {
            padding: 0.25rem 0.1rem !important;
        }

        table tbody td {
            padding: 0.25rem 0.1rem !important;
        }

        .btn-sm {
            font-size: 0.55rem;
            padding: 0.25rem 0.35rem;
        }

        .badge {
            font-size: 0.65rem;
        }

        .form-control,
        .form-select,
        .btn {
            font-size: 0.75rem;
            padding: 0.35rem 0.5rem;
        }

        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .collapse {
            font-size: 0.7rem;
        }

        .table-sm {
            font-size: 0.6rem;
        }
    }
</style>
@endpush

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-1">
        <div class="d-flex align-items-start">
            <h1>Orders</h1>
            <span class="badge text-success">{{ $orders->total() }}</span>
        </div>

        <!-- Search and Sort Section -->
        <div class="row g-3 w-100">
            <div class="col-12 col-md-6">
                <form method="GET" action="{{ route('admin.orders') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control rounded-0" placeholder="Search orders by customer name, email, or order ID..." value="{{ $search ?? '' }}">
                    <input type="hidden" name="sort" value="{{ $sort ?? 'newest' }}">
                    <button type="submit" class="btn btn-dark rounded-0">Search</button>
                    @if($search)
                    <a href="{{ route('admin.orders') }}" class="btn btn-secondary rounded-0">Clear</a>
                    @endif
                </form>
            </div>

            <div class="col-12 col-md-6">
                <form method="GET" action="{{ route('admin.orders') }}" class="d-flex gap-2">
                    <select name="sort" class="form-select rounded-0" onchange="this.form.submit()">
                        <option value="newest" {{ ($sort ?? 'newest') === 'newest' ? 'selected' : '' }}>Sort: Newest First</option>
                        <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Sort: Oldest First</option>
                        <option value="name_asc" {{ ($sort ?? '') === 'name_asc' ? 'selected' : '' }}>Sort: Customer Name (A-Z)</option>
                        <option value="name_desc" {{ ($sort ?? '') === 'name_desc' ? 'selected' : '' }}>Sort: Customer Name (Z-A)</option>
                        <option value="email_asc" {{ ($sort ?? '') === 'email_asc' ? 'selected' : '' }}>Sort: Email (A-Z)</option>
                        <option value="email_desc" {{ ($sort ?? '') === 'email_desc' ? 'selected' : '' }}>Sort: Email (Z-A)</option>
                        <option value="total_asc" {{ ($sort ?? '') === 'total_asc' ? 'selected' : '' }}>Sort: Total (Low to High)</option>
                        <option value="total_desc" {{ ($sort ?? '') === 'total_desc' ? 'selected' : '' }}>Sort: Total (High to Low)</option>
                    </select>
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Total</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody>

                @forelse($orders as $order)
                @if($order->order_status !== 'cart')
                <tr>
                    <td><strong>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td><strong>₹{{ number_format($order->items->sum(fn($i) => $i->product->sale_price * $i->quantity), 2) }}</strong></td>

                    <td>
                        <form action="{{ route('orders.updatePaymentStatus', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <select name="payment_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </form>
                    </td>

                    <td>
                        <form action="{{ route('orders.updateOrderStatus', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <select name="order_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>

                    <td>
                        <button class="btn btn-outline-dark rounded-0 py-1" type="button" data-bs-toggle="collapse" data-bs-target="#details-{{ $order->id }}">View</button>
                    </td>
                </tr>

                <tr>
                    <td colspan="8" style="padding: 0; border: none;">
                        <div class="collapse" id="details-{{ $order->id }}">
                            <div style="padding: 20px; background-color: #f9f9f9; border-top: 1px solid #ddd;">
                                <table class="table table-sm" style="margin-bottom: 20px;">
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;"><strong>Full Name:</strong></td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $order->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;"><strong>Email:</strong></td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $order->email }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;"><strong>Phone:</strong></td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $order->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;"><strong>Address:</strong></td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $order->address }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;"><strong>City:</strong></td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $order->city }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;"><strong>State:</strong></td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $order->state }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;"><strong>Pincode:</strong></td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $order->pincode }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;"><strong>Payment Method:</strong></td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</td>
                                    </tr>
                                </table>

                                <h6><b>Order Items</b></h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead style="background-color: #f0f0f0;">
                                            <tr>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>₹{{ number_format($item->price, 2) }}</td>
                                                <td><strong>₹{{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endif

                    @empty

                    <div class="text-center">
                        <h3>No Orders Found.</h3>
                    </div>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 ms-auto">
        <nav>
            {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
        </nav>
    </div>

</div>

@endsection

@extends('layouts.admin.main')

@section('title', 'Orders')

<!-- @push('styles')
<style>
    
</style>
@endpush -->

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-1">
        <h3><b>Orders</b></h3>
        <span class="badge rounded-0 text-bg-secondary py-2 px-3">Total: {{ $orders->count() }}</span>
    </div>

    <table class="table table-hover table-striped table-bordered">
        <thead style="background-color: #2c3e50; color: white;">
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
                <td><strong>₹{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}</strong></td>

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
                </td>
            </tr>
            @endif

            @empty
            <tr>
                <td colspan="8" class="text-center">
                    <h4>No Orders Found</h4>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
@extends('layouts.admin.main')

@section('title', 'Orders')

<!-- @push('styles')

@endpush -->

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-1">
        <h3><b>Orders</b></h3>
    </div>

    <table class="table table-hover table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">User id</th>
                <th scope="col">Total</th>
                <th scope="col">Payment status</th>
                <th scope="col">Order status</th>
            </tr>
        </thead>
        <tbody>

            @forelse($orders as $order)
            <tr>
                <td>{{$order->user_id}}</td>
                <td>{{$order->total}}</td>

                <td>
                    <form action="{{ route('orders.updatePaymentStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <select name="payment_status"
                            class="form-select form-select-sm"
                            onchange="this.form.submit()">

                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>

                        </select>
                    </form>
                </td>


                <td>
                    <form action="{{ route('orders.updateOrderStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <select name="order_status"
                            class="form-select form-select-sm"
                            onchange="this.form.submit()">

                            <option value="cart" {{ $order->order_status == 'cart' ? 'selected' : '' }}>Cart</option>
                            <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>

                        </select>
                    </form>
                </td>


                @empty
                <div class="text-center">
                    <h3>No Order Found.</h3>
                </div>
            </tr>
            @endforelse
        </tbody>
    </table>

    <hr>

    <div class="d-flex align-items-center justify-content-between mb-1">
        <h3><b>Order Items</b></h3>
    </div>

    <table class="table table-hover table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">Order id</th>
                <th scope="col">Product_id</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>

            @forelse($orderItems as $orderItem)
            <tr>
                <td>{{$orderItem->order_id}}</td>
                <td>{{$orderItem->product_id}}</td>
                <td>{{$orderItem->quantity}}</td>
                <td>{{$orderItem->price}}</td>
                @empty
                <div class="text-center">
                    <h3>No Order Found.</h3>
                </div>
            </tr>
            @endforelse
        </tbody>
    </table>


</div>

@endsection
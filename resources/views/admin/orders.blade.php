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
                <td>{{$order->payment_status}}</td>
                <td>{{$order->order_status}}</td>
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
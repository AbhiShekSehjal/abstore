@extends('layouts.admin.main')

@section('title', 'Home')

@php
use Illuminate\Support\Str;
@endphp

@push('styles')
<style>
    .countBox {
        text-decoration: none;
    }

    /* Chart Container Styling */
    .chart-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pie-chart-wrapper {
        max-width: 280px;
        margin: 0 auto;
        width: 100%;
    }

    .card-header {
        border-bottom: 2px solid #495057 !important;
    }

    .card {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')

<h1 class='mt-4'>Dashboard</h1>

<div class="row d-flex flex-wrap">
    <a href='/admin/products'
        class="col-lg-4 bg-secondary border p-5 text-white d-flex align-items-center justify-content-between countBox">
        <h1>Products</h1>
        <h1><b>{{ $products->count() }}</b></h1>
    </a>
    <a href='/admin/categories'
        class="col-lg-4 bg-secondary border p-5 text-white d-flex align-items-center justify-content-between countBox">
        <h1>Categories</h1>
        <h1><b>{{ $categories->count() }}</b></h1>
    </a>
    <a href='/admin/orders'
        class="col-lg-4 bg-secondary border p-5 text-white d-flex align-items-center justify-content-between countBox">
        <h1>Orders</h1>
        <h1><b>{{ $orders->count() }}</b></h1>
    </a>
    <a href='/admin/users'
        class="col-lg-4 bg-secondary border p-5 text-white d-flex align-items-center justify-content-between countBox">
        <h1>Users</h1>
        <h1><b>{{ $users->count() }}</b></h1>
    </a>
</div>

<!-- Revenue Statistics Section -->
<div class="row d-flex flex-wrap mt-5">
    <h3 class="mb-4">Revenue Statistics</h3>
    <div class="row d-flex flex-wrap">
        <div class="col-lg-4 bg-secondary border p-4 text-white">
            <h5>Total Revenue</h5>
            <h3><b>₹{{ number_format($totalRevenue ?? 0, 2) }}</b></h3>
            <small class="opacity-75">All time sales</small>
        </div>
        <div class="col-lg-4 bg-secondary border p-4 text-white">
            <h5>Today's Revenue</h5>
            <h3><b>₹{{ number_format($todayRevenue ?? 0, 2) }}</b></h3>
            <small class="opacity-75">Today's sales</small>
        </div>
        <div class="col-lg-4 bg-secondary border p-4 text-white">
            <h5>This Month Revenue</h5>
            <h3><b>₹{{ number_format($monthRevenue ?? 0, 2) }}</b></h3>
            <small class="opacity-75">{{ date('F Y') }}</small>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mt-5">
    <h3 class="mb-4">Business Analytics</h3>



    <!-- Sales by Category Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h5 class="mb-0">Sales by Category</h5>
            </div>
            <div class="card-body chart-container">
                <div class="pie-chart-wrapper">
                    <canvas id="categoryChart" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Distribution -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h5 class="mb-0">Order Status Distribution</h5>
            </div>
            <div class="card-body chart-container">
                <div class="pie-chart-wrapper">
                    <canvas id="orderStatusChart" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Trend Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h5 class="mb-0">Revenue Trend (Last 7 Days)</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="140"></canvas>
            </div>
        </div>
    </div>

    <!-- Payment Method Distribution -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h5 class="mb-0">Payment Methods</h5>
            </div>
            <div class="card-body chart-container">
                <div class="pie-chart-wrapper">
                    <canvas id="paymentMethodChart" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Comparison -->
    <div class="col-lg-12 mb-4">
        <div class="card h-100 rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h5 class="mb-0">Monthly Revenue Comparison (Last 6 Months)</h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyRevenueChart" height="50"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <h3 class="mb-4">Order Overview</h3>

    <div class="col-lg-6 mb-4">
        <div class="card h-100 rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h5 class="mb-0">Order Status Breakdown</h5>
            </div>
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span>Pending</span>
                    <span class="badge bg-warning">{{ $orderStatusBreakdown['pending'] ?? 0 }}</span>
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span>Processing</span>
                    <span class="badge bg-info">{{ $orderStatusBreakdown['processing'] ?? 0 }}</span>
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span>Shipped</span>
                    <span class="badge bg-primary">{{ $orderStatusBreakdown['shipped'] ?? 0 }}</span>
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span>Delivered</span>
                    <span class="badge bg-success">{{ $orderStatusBreakdown['delivered'] ?? 0 }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Cancelled</span>
                    <span class="badge bg-danger">{{ $orderStatusBreakdown['cancelled'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100 rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h5 class="mb-0">Payment Status Breakdown</h5>
            </div>
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span>Paid</span>
                    <span class="badge bg-success">{{ $paymentStatusBreakdown['paid'] ?? 0 }}</span>
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <span>Pending</span>
                    <span class="badge bg-warning">{{ $paymentStatusBreakdown['pending'] ?? 0 }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Failed</span>
                    <span class="badge bg-danger">{{ $paymentStatusBreakdown['failed'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Section -->
<div class="row mt-4">
    <h3 class="mb-4">Recent Orders</h3>

    <div class="col-12">
        <div class="card rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h5 class="mb-0">Latest 5 Orders</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>₹{{ number_format($order->total ?? 0, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $order->order_status === 'delivered' ? 'success' : ($order->order_status === 'pending' ? 'warning' : 'info') }}">
                                    {{ ucfirst($order->order_status ?? 'pending') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->payment_status ?? 'pending') }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-3">No orders yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Top Selling Products & Low Stock Alerts -->
<div class="row mt-5">
    <h3 class="mb-4">Inventory & Sales</h3>

    <div class="col-lg-6 mb-4">
        <div class="card h-100 rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h5 class="mb-0">Top Selling Products</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts ?? [] as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <div style="width: 40px; height: 40px; background-color: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                        <small class="text-muted">No Image</small>
                                    </div>
                                @endif
                            </td>
                            <td>{{ Str::limit($product->name ?? '', 25) }}</td>
                            <td><strong>{{ $product->sales_count ?? 0 }}</strong></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-3 text-muted">No sales data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100 rounded-0">
            <div class="card-header bg-dark text-white rounded-0">
                <h5 class="mb-0">Low Stock Alerts <span class="badge bg-danger">{{ $lowStockCount ?? 0 }}</span></h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockProducts ?? [] as $product)
                        <tr class="table-warning">
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <div style="width: 40px; height: 40px; background-color: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                        <small class="text-muted">No Image</small>
                                    </div>
                                @endif
                            </td>
                            <td>{{ Str::limit($product->name ?? '', 25) }}</td>
                            <td><strong class="text-danger">{{ $product->stock ?? 0 }}</strong></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-3 text-success">✓ All items well stocked</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Customer Statistics -->



<div class="row p-3 d-flex flex-wrap">
    <h3 class="mb-4 p-0">Customer Insights</h3>
    <div class="row d-flex flex-wrap">
        <div class="col-lg-4 bg-secondary border p-4 text-white">
            <h5>Total Customers</h5>
            <h3><b>{{ $totalCustomers ?? 0 }}</b></h3>
            <small class="opacity-75">Registered users</small>
        </div>
        <div class="col-lg-4 bg-secondary border p-4 text-white">
            <h5>New Customers</h5>
            <h3><b>{{ $newCustomersThisMonth ?? 0 }}</b></h3>
            <small class="opacity-75">This month</small>
        </div>
        <div class="col-lg-4 bg-secondary border p-4 text-white">
            <h5>Repeat Customers</h5>
            <h3><b>{{ $repeatCustomers ?? 0 }}</b></h3>
            <small class="opacity-75">2+ orders</small>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Trend Chart (Last 7 Days)
    const ctx1 = document.getElementById('revenueChart').getContext('2d');
    const revenueData = JSON.parse('{!! addslashes(json_encode($last7DaysRevenue ?? [])) !!}');
    const revenueLabels = JSON.parse('{!! addslashes(json_encode($last7DaysLabels ?? [])) !!}');

    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Daily Revenue',
                data: revenueData,
                borderColor: '#4CAF50',
                backgroundColor: 'rgba(76, 175, 80, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#4CAF50',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value;
                        }
                    }
                }
            }
        }
    });

    // Sales by Category Chart
    const ctx2 = document.getElementById('categoryChart').getContext('2d');
    const categoryData = JSON.parse('{!! addslashes(json_encode($categoryRevenue ?? [])) !!}');
    const categoryLabels = JSON.parse('{!! addslashes(json_encode($categoryLabels ?? [])) !!}');

    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                    '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });

    // Order Status Distribution
    const ctx3 = document.getElementById('orderStatusChart').getContext('2d');
    const orderStatusData = JSON.parse('{!! addslashes(json_encode(array_values($orderStatusBreakdown ?? []))) !!}');
    const orderStatusLabels = JSON.parse('{!! addslashes(json_encode(array_keys($orderStatusBreakdown ?? []))) !!}');

    new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: orderStatusLabels.map(label => label.charAt(0).toUpperCase() + label.slice(1)),
            datasets: [{
                data: orderStatusData,
                backgroundColor: [
                    '#FFC107', '#FF9800', '#2196F3', '#4CAF50', '#F44336'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });

    // Payment Method Chart
    const ctx4 = document.getElementById('paymentMethodChart').getContext('2d');
    const paymentMethodData = JSON.parse('{!! addslashes(json_encode($paymentMethodData ?? [])) !!}');
    const paymentMethodLabels = JSON.parse('{!! addslashes(json_encode($paymentMethodLabels ?? [])) !!}');

    // Normalize labels for consistent coloring (COD, Cod -> COD)
    const normalizedLabels = paymentMethodLabels.map(label => {
        const normalized = label.toLowerCase();
        if (normalized === 'cod' || normalized === 'cash on delivery') return 'COD';
        if (normalized === 'razorpay' || normalized === 'card') return 'Card';
        if (normalized === 'online') return 'Online';
        return label;
    });

    // Assign different colors to different payment methods
    const paymentMethodColors = {
        'COD': '#FF6B6B',
        'Card': '#4ECDC4',
        'Online': '#45B7D1',
        'Razorpay': '#FFA502',
        'Credit Card': '#4ECDC4',
        'Debit Card': '#4ECDC4'
    };

    const colors = normalizedLabels.map(label => paymentMethodColors[label] || '#4ECDC4');

    new Chart(ctx4, {
        type: 'doughnut',
        data: {
            labels: normalizedLabels,
            datasets: [{
                data: paymentMethodData,
                backgroundColor: colors,
                borderColor: '#fff',
                borderWidth: 3,
                hoverBorderWidth: 4,
                hoverOffset: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '50%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 12,
                            weight: 'bold'
                        },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' transactions';
                        }
                    }
                }
            }
        }
    });

    // Monthly Revenue Comparison
    const ctx5 = document.getElementById('monthlyRevenueChart').getContext('2d');
    const monthlyRevenueData = JSON.parse('{!! addslashes(json_encode($last6MonthsRevenue ?? [])) !!}');
    const monthlyLabels = JSON.parse('{!! addslashes(json_encode($last6MonthsLabels ?? [])) !!}');

    new Chart(ctx5, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Monthly Revenue',
                data: monthlyRevenueData,
                backgroundColor: '#3498db',
                borderColor: '#2980b9',
                borderWidth: 2,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
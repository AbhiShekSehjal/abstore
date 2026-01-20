<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminIndexController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $products   = Product::all();
            $categories = Category::all();
            $orders     = Order::all();
            $users      = User::all();

            // Revenue Statistics
            $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
            $todayRevenue = Order::where('payment_status', 'paid')
                ->whereDate('created_at', today())
                ->sum('total');
            $monthRevenue = Order::where('payment_status', 'paid')
                ->whereMonth('created_at', today()->month)
                ->whereYear('created_at', today()->year)
                ->sum('total');

            // Order Status Breakdown
            $orderStatusBreakdown = [
                'pending' => Order::where('order_status', 'pending')->count(),
                'processing' => Order::where('order_status', 'processing')->count(),
                'shipped' => Order::where('order_status', 'shipped')->count(),
                'delivered' => Order::where('order_status', 'delivered')->count(),
                'cancelled' => Order::where('order_status', 'cancelled')->count(),
            ];

            // Payment Status Breakdown
            $paymentStatusBreakdown = [
                'paid' => Order::where('payment_status', 'paid')->count(),
                'pending' => Order::where('payment_status', 'pending')->count(),
                'failed' => Order::where('payment_status', 'failed')->count(),
            ];

            // Recent Orders (Last 5)
            $recentOrders = Order::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Top Selling Products
            $topProducts = OrderItem::selectRaw('product_id, COUNT(*) as sales_count')
                ->groupBy('product_id')
                ->with('product')
                ->orderBy('sales_count', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'name' => $item->product->name ?? 'N/A',
                        'image' => $item->product->image ?? null,
                        'sales_count' => $item->sales_count,
                    ];
                });

            // Low Stock Products (Below 20 units)
            $lowStockProducts = Product::where('stock', '<', 20)
                ->orderBy('stock', 'asc')
                ->limit(5)
                ->get();
            $lowStockCount = Product::where('stock', '<', 20)->count();

            // Customer Statistics
            $totalCustomers = User::where('role', 'user')->count();
            $newCustomersThisMonth = User::where('role', 'user')
                ->whereMonth('created_at', today()->month)
                ->whereYear('created_at', today()->year)
                ->count();
            $repeatCustomers = User::where('role', 'user')
                ->whereHas('orders', function ($query) {
                    $query->where('payment_status', 'paid');
                }, '>=', 2)
                ->count();

            // Revenue Trend - Last 7 Days
            $last7DaysRevenue = [];
            $last7DaysLabels = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = today()->subDays($i);
                $revenue = Order::where('payment_status', 'paid')
                    ->whereDate('created_at', $date)
                    ->sum('total');
                $last7DaysRevenue[] = $revenue;
                $last7DaysLabels[] = $date->format('M d');
            }

            // Sales by Category
            $categoryRevenue = [];
            $categoryLabels = [];
            $categoryData = Category::with('products')->get();
            foreach ($categoryData as $category) {
                $revenue = OrderItem::whereIn('product_id', $category->products->pluck('id'))
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.payment_status', 'paid')
                    ->sum('order_items.price');
                if ($revenue > 0) {
                    $categoryLabels[] = $category->name;
                    $categoryRevenue[] = $revenue;
                }
            }

            // Payment Method Distribution
            $paymentMethodData = [];
            $paymentMethodLabels = [];
            $methods = Order::select('payment_method', DB::raw('COUNT(*) as count'))
                ->groupBy('payment_method')
                ->get();
            foreach ($methods as $method) {
                $paymentMethodLabels[] = ucfirst($method->payment_method ?? 'COD');
                $paymentMethodData[] = $method->count;
            }

            // Last 6 Months Revenue
            $last6MonthsRevenue = [];
            $last6MonthsLabels = [];
            for ($i = 5; $i >= 0; $i--) {
                $date = today()->subMonths($i);
                $revenue = Order::where('payment_status', 'paid')
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->sum('total');
                $last6MonthsRevenue[] = $revenue;
                $last6MonthsLabels[] = $date->format('M Y');
            }

            return view('admin.index', compact(
                'products',
                'categories',
                'orders',
                'users',
                'totalRevenue',
                'todayRevenue',
                'monthRevenue',
                'orderStatusBreakdown',
                'paymentStatusBreakdown',
                'recentOrders',
                'topProducts',
                'lowStockProducts',
                'lowStockCount',
                'totalCustomers',
                'newCustomersThisMonth',
                'repeatCustomers',
                'last7DaysRevenue',
                'last7DaysLabels',
                'categoryRevenue',
                'categoryLabels',
                'paymentMethodData',
                'paymentMethodLabels',
                'last6MonthsRevenue',
                'last6MonthsLabels'
            ));
        } else {
            return redirect()->route('AdminLoginPage');
        }
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrdersController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $search = $request->input('search', '');
            $sort = $request->input('sort', 'newest');
            
            $query = Order::query();

            // Apply search filter
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('id', 'like', '%' . $search . '%');
            }

            // Apply sorting
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'email_asc':
                    $query->orderBy('email', 'asc');
                    break;
                case 'email_desc':
                    $query->orderBy('email', 'desc');
                    break;
                case 'total_asc':
                    $query->orderByRaw('(SELECT SUM(price * quantity) FROM order_items WHERE order_items.order_id = orders.id) ASC');
                    break;
                case 'total_desc':
                    $query->orderByRaw('(SELECT SUM(price * quantity) FROM order_items WHERE order_items.order_id = orders.id) DESC');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }

            $orders = $query->paginate(10);
            $orderItems = OrderItem::all();

            return view('admin.orders', compact('orders', 'orderItems', 'search', 'sort'));
        } else {
            return redirect()->route('AdminLoginPage');
        }
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Payment status updated!');
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:cart,pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order->update([
            'order_status' => $request->order_status,
        ]);

        return back()->with('success', 'Order status updated!');
    }
}

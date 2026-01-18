<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin\Setting;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // Get only current user's orders (excluding cart status)
            $orders = Order::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->with('items.product')
                ->get();
            
            $settings = Setting::first();

            return view('myOrders', compact('orders', 'settings'));
        } else {
            return redirect()->route('LoginPage');
        }
    }

    public function submitFeedback(Request $request, $orderId)
    {
        if (!Auth::check()) {
            return redirect()->route('LoginPage');
        }

        // Find the order and verify it belongs to the authenticated user
        $order = Order::find($orderId);

        if (!$order || $order->user_id !== Auth::id()) {
            return redirect()->route('orders.track')
                ->with('error', 'Unauthorized access');
        }

        // Check if order is delivered
        if ($order->order_status !== 'delivered') {
            return redirect()->route('orders.track')
                ->with('error', 'You can only submit feedback for delivered orders');
        }

        // Validate feedback
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Please select a rating',
            'rating.integer' => 'Rating must be a number',
            'rating.min' => 'Rating must be between 1 and 5',
            'rating.max' => 'Rating must be between 1 and 5',
            'feedback.required' => 'Please write your feedback',
            'feedback.min' => 'Feedback must be at least 10 characters',
            'feedback.max' => 'Feedback cannot exceed 1000 characters',
        ]);

        // Update order with feedback
        $order->update([
            'rating' => $validated['rating'],
            'feedback' => $validated['feedback'],
        ]);

        return redirect()->route('orders.track')
            ->with('success', 'Thank you for your feedback! We appreciate your review.');
    }
}

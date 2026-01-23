<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'payment_status',
        'payment_method',
        'order_status',
        'name',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'pincode',
        'feedback',
        'rating',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate and get the total amount from items
     */
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->product->sale_price * $item->quantity;
        }
        return $total;
    }

    /**
     * Get order total, calculate if not set
     */
    public function getTotalAmount()
    {
        if ($this->total > 0) {
            return $this->total;
        }
        return $this->calculateTotal();
    }
}

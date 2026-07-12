<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'recipient_name', 'total_price', 'status', 'snap_token', 'product_id', 'quantity',

        'shipping_address', 'shipping_courier', 'shipping_cost', 'tax_fee', 'insurance_fee', 'admin_fee', 'delivery_status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

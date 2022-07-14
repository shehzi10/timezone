<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'order_id', 'quantity',  'price', 'vat_percent', 'vat_amount',
        'discount_id', 'discount_amount', 'total_price'
    ];
}

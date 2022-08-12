<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'order_id',  'price', 'vat_percent', 'vat_amount',
        'discount_amount', 'total_price'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'payment_method_id', 'sub_total', 'vat_percent', 'vat_amount',
        'discount_id', 'discount_amount', 'total', 'status'
    ];
}
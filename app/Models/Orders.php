<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'payment_method_id', 'delivery_address_id', 'sub_total', 'vat_percent', 'vat_amount',
        'discount_amount', 'total', 'charge_id', 'blc_transaction_id', 'status'
    ];
}

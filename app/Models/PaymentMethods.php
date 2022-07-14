<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'stripe_card_id', 'card_brand', 'card_end_number', 'is_default', 'status'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeImage extends Model
{
    use HasFactory;


    protected $fillable = ['trade_id', 'image'];


    public function trade(){
        return $this->belongsTo(Trade::class, 'trade_id', 'id');
    }
}

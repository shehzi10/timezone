<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    public const PACKING_BOX = 'packing_box';
    public const PACKING_PAPER = 'packing_paper';
    public const PACKING_BOXANDPAPER = 'packing_box and paper';
    public const PACKING_NONE = 'packing_none';





    protected $fillable = ['user_id','name','email','phone','model_num', 'brand_id', 'model_name', 'model_price', 'model_condition', 'packing', 'comments'];



    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}

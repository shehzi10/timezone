<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'brand_id', 'category_id', 'color_id', 'price', 'gender' , 'style', 'image', 'case_material', 'availability',
                            'description', 'condition', 'weight'];


    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'category_id', 'id');
    }

    public function color(){
        return $this->belongsTo(Color::class, 'category_id', 'id');
    }
}

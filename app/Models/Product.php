<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_name', 'brand_id', 'category_id', 'color_id', 'price', 'gender' , 'style', 'image', 'case_material', 'availability',
                            'description', 'condition', 'weight', 'popular_watch'];

    protected $append = ['wishlist'];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function color(){
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function getWishlistAttribute(){

        $wishlist = Wishlist::where('user_id', $this->user_id)->get();
        if($wishlist->count() > 0)
        {
            return true;
        }
            return false;
    }
}

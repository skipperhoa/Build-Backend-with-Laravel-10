<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    // một sản phẩm có thể thuộc về một danh mục nào đó
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function carts() {
        return $this->hasMany(Cart::class, 'product_id');
    }

    public function ordersDetails() {
        return $this->hasMany(OrderDetail::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'keywords',
        'slug',
        'description',
        'image',
        'price',
        'body',
        'category_id',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    // một sản phẩm có thể thuộc về một danh mục nào đó
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
     public function carts():BelongsToMany{
        return $this->belongsToMany(\App\Models\Cart::class,'cart_item','product_id','cart_id')->withPivot('quantity');
    }

    public function ordersDetails() {
        return $this->hasMany(OrderDetail::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Cart extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id'
    ];
    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
     public function products():BelongsToMany{
        return $this->belongsToMany(\App\Models\Product::class,'cart_item','cart_id','product_id')->withPivot('quantity');;
    }
}

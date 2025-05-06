<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* Ghi chú:
Link tham khảo: https://hoanguyenit.com/create-multiple-subcategories-in-laravel-5-8.html
*/

class Category extends Model
{
    use HasFactory;
    public $fillable = [
        'title',
        'slug',
        'image',
        'category_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    // một danh mục có thể thuộc về một danh mục cha nào đó
    // quan hệ nhiều một (many to one) của chính nó
    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // một danh mục có thể có nhiều danh mục con
    // quan hệ một nhiều (one to many) với chính nó
    public function children()
    {
        return $this->hasMany(Category::class, 'category_id');
    }
}

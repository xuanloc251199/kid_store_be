<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'name',
        'category_id',
        'detail',
        'description',
        'price',
        'thumbnail',
        'sold',
        'quantity',
    ];

    // Định nghĩa mối quan hệ với bảng categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
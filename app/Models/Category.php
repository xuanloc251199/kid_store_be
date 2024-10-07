<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu bảng không phải là dạng số nhiều của tên model
    protected $table = 'categories';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'name',
        'thumbnail',
        'description',
    ];

    // Định nghĩa mối quan hệ với bảng products (nếu có)
    public function products()
    {
        return $this->hasMany(Product::class); // Nếu bạn có model Product
    }
}
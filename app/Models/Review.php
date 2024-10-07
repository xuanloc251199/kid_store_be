<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
    ];

    // Định nghĩa mối quan hệ với bảng users
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Unknown User', // Trường hợp user không tồn tại
        ]);
    }

    // Định nghĩa mối quan hệ với bảng products
    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' => 'Unknown Product', // Trường hợp product không tồn tại
        ]);
    }

    // Ví dụ về một accessor nếu muốn Create định dạng cụ thể cho rating
    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1); // Format điểm rating với 1 chữ số thập phân
    }
}

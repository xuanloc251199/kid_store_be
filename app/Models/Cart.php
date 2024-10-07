<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Đặt tên bảng (nếu cần)
    protected $table = 'cart'; // Nếu bảng thực sự là 'cart', nếu không thì có thể bỏ

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
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
}

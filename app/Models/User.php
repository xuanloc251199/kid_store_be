<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; // Để hỗ trợ API tokens

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;

    // Khai báo bảng tương ứng (nếu không theo chuẩn Laravel)
    protected $table = 'users';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'role_id',  // Nếu chỉ có một vai trò
        'name',
        'email',
        'password',
        'number_phone',
        'address',
        'avatar',
    ];

    // Ẩn những thuộc tính không muốn xuất hiện khi model được chuyển sang dạng JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Định nghĩa kiểu dữ liệu cho các trường
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Định nghĩa quan hệ với Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}

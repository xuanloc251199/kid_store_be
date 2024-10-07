<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // Định nghĩa mối quan hệ với bảng users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
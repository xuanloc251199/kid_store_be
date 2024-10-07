<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'name',
        'thumbnail',
        'place',
        'date',
        'detail',
        'description',
        'price',
        'number_ticket',
    ];
}
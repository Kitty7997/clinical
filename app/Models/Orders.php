<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'payment_method_type',
        'status',
        'product_image',
        'product_head',
        'quantity',
        'total',
        'address'
    ];
}

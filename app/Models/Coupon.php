<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class Coupon extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'coupon';

    public function getCoupon($code)
    {
        $existCode = Coupon::where('code', $code)->first();
       
        $cart = (new Cart())->cartData();

        $newTotal = $cart->sum('totalPrice');

        $data = [];
        
        if ($existCode) {
            if ($existCode->type == 'amount') {
                Session::flash('success', 'Discount applied');
                $data['discount'] = $existCode->discount;
                $data['totalValue'] = $newTotal - $data['discount'];
            } elseif ($existCode->type == 'percentage') {
                $data['discount'] = $existCode->discount;
                $data['totalValue'] = $newTotal - ($newTotal * $data['discount'] / 100);
            }
        }

        return $data;
    }
}


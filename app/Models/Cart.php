<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';

    public function cartData(){
        $userId = Auth::user()->id;

        $cart = DB::table('cart')
        ->select('cart.*', 'clinical.image', 'clinical.head', 'clinical.price','clinical.id as productId', DB::raw('SUM(clinical.price * cart.quantity) as totalPrice'))
        ->where('cart.user_id', $userId)
        ->join('clinical', DB::raw("FIND_IN_SET(clinical.id, cart.product_id)"), '>', DB::raw("'0'"))
        ->groupBy('cart.id','clinical.head','clinical.image','clinical.price','clinical.id')
        ->orderBy('clinical.id', 'asc')
        ->get();

        return  $cart;

    }
}

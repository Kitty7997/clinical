<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function orderNow(){
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();
        
        $data = compact('item');
        return view('frontend/order')->with($data);
    }
}

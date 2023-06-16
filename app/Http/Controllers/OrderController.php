<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orderNow(){
        $userId = Auth::user();
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId->id)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();
        
        $itemCount = $item->where('user_id',$userId->id)->count();

        $data = compact('item','itemCount');
        return view('frontend/order')->with($data);
    }
}

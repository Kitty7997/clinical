<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Cart;

class OrderController extends Controller
{
    public function orderNow(){
        $order = new Order;
        $userId = Auth::user();
        $cartValue = Cart::all();
        $order->user_id = $userId->id;
        $order->product_id = $cartValue->product_id;
        $order->quantity = $cartValue->quantity;


        $item = null;
        $itemCount = 0;
        if($userId){
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId->id)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();
        // dd($item);
    
      $itemCount = $item->where('user_id',$userId->id)->count();
    }

        $data = compact('item','itemCount');
        return view('frontend/order')->with($data);
    }
}

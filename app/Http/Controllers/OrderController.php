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
        $userId = Auth::user();
        $cartItems = Cart::where('user_id', $userId->id)->get();
        // dd($cartItems);

       foreach($cartItems as $cartItem){
        $order = new Order;
        $order->user_id = $userId->id;
        $order->product_id = $cartItem->product_id;
        $order->quantity = $cartItem->quantity;
        }

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

        $data = compact('item','itemCount','cartItems');
        return view('frontend/order')->with($data);
    }
}

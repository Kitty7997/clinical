<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Orders;
use App\Models\Cart;

class OrderController extends Controller
{
    public function orderNow(){
       $userId = Auth::user()->id;
       
       $order = Orders::where('user_id',$userId)->orderBy('created_at','desc')->get();
   
        $item = (new Cart())->cartData();
    
         $itemCount = $item->where('user_id',$userId)->count();
        
         $orderCount = $order->count();

        $data = compact('item','itemCount','order','orderCount');
        return view('frontend/order')->with($data);
    }



    public function removeorder($id){
        $userId = Auth::user()->id;
        $orderValue = Orders::destroy($id);
        $order = Orders::where('user_id',$userId)->orderBy('created_at','desc')->get();
        $ordercount = $order->count();
        return response()->json(['order' => $ordercount]);
    }
}

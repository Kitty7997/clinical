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
       $order = Orders::where('user_id',$userId)->get();

        $item = null;
        $itemCount = 0;
        
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();
    
      $itemCount = $item->where('user_id',$userId)->count();
    

        $data = compact('item','itemCount','order');
        return view('frontend/order')->with($data);
    }

    public function removeorder($id){
        $orderValue = Orders::destroy($id);
        return redirect()->back();
    }
}

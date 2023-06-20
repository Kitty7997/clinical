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
        $userId = Auth::user();
       $order = Orders::all();

        $item = null;
        $itemCount = 0;
        if($userId){
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId->id)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();
    
      $itemCount = $item->where('user_id',$userId->id)->count();
    }

        $data = compact('item','itemCount','order');
        return view('frontend/order')->with($data);
    }

    public function removeorder($id){
        $orderValue = Orders::destroy($id);
        return redirect()->back();
    }
}

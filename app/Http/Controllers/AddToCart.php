<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Clinical;
use Illuminate\Support\Facades\DB;

class AddToCart extends Controller
{
    public function addTocart(Request $request)
    {
        $cart = new Cart;
        $cart->product_id = $request->input('product_id');
        $cart->save();
        // echo $cart;
        return redirect()->back();
    }
    

    public function viewCart(){
        $clinicaldata = Clinical::all();
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();

        $total = DB::table('cart')
        ->join('clinical', 'clinical.id','=','cart.product_id')
        ->sum('clinical.price');
        // echo "<pre>";
        // print_r($total);
        $data = compact('item','total','clinicaldata');
        return view('frontend/cart')->with($data);
    }

    public function removeData($id){
        $item = Cart::destroy($id);
        return redirect()->back(); 
    }

}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Clinical;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AddToCart extends Controller
{
    public function addTocart(Request $request)
    {
        $cart = Cart::where('product_id', $request->input('product_id'))->first();
        if ($cart) {
            $cart->increment('quantity');
        } else {
            $cart = new Cart;
            $cart->product_id = $request->input('product_id');
            $cart->save();
        }
        $request->session()->put('cart',$cart);
        return redirect()->back();
    }

    public function viewCart(Request $request){
        $clinicaldata = Clinical::take(2)->get();
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();
        // $NewtotalPrice = 0;
        foreach($item as $key=>$value){
            $item[$key]->totalPrice=$value->price * $value->quantity;
            // $NewtotalPrice = $NewtotalPrice + $item[$key]->totalPrice;
        }


        // dd($NewtotalPrice);
        // $total = DB::table('cart')
        // ->join('clinical', 'clinical.id','=','cart.product_id')
        // ->sum('clinical.price');



        $newTotal = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));
        
        $cart = $request->session()->get('item');
      
 
        $data = compact('item','clinicaldata','newTotal','cart');


        return view('frontend/cart')->with($data);
    }


    public function removeData($id){
        $item = Cart::destroy($id);
        return redirect()->back(); 
    }

}


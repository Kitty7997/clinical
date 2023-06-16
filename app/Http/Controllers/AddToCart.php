<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Clinical;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AddToCart extends Controller
{
    public function addTocart(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('product_id', $request->input('product_id'))
        ->where('user_id', $user->id)
        ->first();
        if ($cart) {
            $cart->increment('quantity');
        } else {
            $cart = new Cart;
            $cart->product_id = $request->input('product_id');
            $cart->user_id = $user->id;
            $cart->save();
        }
        // dd($cart);
        $request->session()->put('cart',$cart);
        return redirect()->back();
    }

    public function viewCart(Request $request){
        $userId = Auth::user();
        $clinicaldata = Clinical::take(2)->get();
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
        ->where('user_id', $userId->id)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));
        
        $cart = $request->session()->get('item');
      
        $data = compact('item','clinicaldata','newTotal','cart','itemCount');


        return view('frontend/cart')->with($data);
    }


    public function removeData($id){
        $item = Cart::destroy($id);
        return redirect()->back(); 
    }

}


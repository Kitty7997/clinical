<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Clinical;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AddToCart extends Controller
{
    public function addToCart(Request $request)
    {
        $userId = Auth::user()->id;
        $couponData = Coupon::all();
    
        $cart = Cart::where('product_id', $request->input('product_id'))
            ->where('user_id', $userId)
            ->first();
    
        if ($cart) {
            $cart->increment('quantity');
        } else {
            $cart = new Cart;
            $cart->product_id = $request->input('product_id');
            $cart->user_id = $userId;
            // $cart->discount = $discount;
            $cart->save();
        }
    
        $request->session()->put('cart', $cart);
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
        //   dd($item);

        $discount = $item->pluck('discount');
        // dd($discount);
        
          $itemCount = $item->where('user_id',$userId->id)->count();
        }
        // $NewtotalPrice = 0;
        foreach($item as $key=>$value){
            $item[$key]->totalPrice=$value->price * $value->quantity;
            // $NewtotalPrice = $NewtotalPrice + $item[$key]->totalPrice;
        }

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
        $userId = Auth::user()->id;
        $item = Cart::destroy($id);
        $existCode = Coupon::first();
        $cart = Cart::where('user_id', $userId)
        ->get();
        // dd($existCode);
        $discount = $existCode ? $existCode->discount : 0;
        $percentageDiscount = $existCode ? $existCode->percentage : 0;
        // dd($discount);

        $newTotal = DB::table('cart')
            ->select('cart.*', 'clinical.image', 'clinical.head', 'clinical.price')
            ->where('user_id', $userId)
            ->join('clinical', 'clinical.id', '=', 'cart.product_id')
            ->sum(DB::raw('clinical.price * cart.quantity'));
    
            if ($discount || $percentageDiscount) {
                if ($newTotal < 100) {
                    // Session::flash('error', 'Discount value has been removed!');
                    foreach ($cart as $item) {
                        $item->discount = 0;
                        $item->percentage = 0;
                        $item->save();
                    }
                    Session::forget('code');
                    Session::forget('percent');
                } 
            }
        return redirect()->back(); 
    }




    public function addToCartAgain(Request $request)
    {
    $userId = Auth::user()->id;
    $couponData = Coupon::all();
    
    $cart = Cart::where('user_id', $userId)->get();
   
    $existCode = Coupon::where('code', $request->input('code'))->first();
    $existPercentage = Coupon::where('coupon', $request->input('code'))->first();
 
    $myCode = $existCode ? $existCode->code : '';
    $myPercentage = $existPercentage ? $existPercentage->coupon : '';

    $discount = $existCode ? $existCode->discount : 0;
    $percentageDiscount = $existPercentage ? $existPercentage->percentage : 0;
    // dd($percentageDiscount);

    $newTotal = DB::table('cart')
        ->select('cart.*', 'clinical.image', 'clinical.head', 'clinical.price')
        ->where('user_id', $userId)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));
        if ($existCode) {
            if ($newTotal > 100) {
                Session::flash('success', 'Discount applied!');
                foreach ($cart as $item) {
                    $item->discount = $discount;
                    $item->save();
                }
                $request->session()->put('code', $myCode);

            } else {
                Session::flash('error', 'Discount code is not eligible');
            }
        }elseif($existPercentage) {
           
            if ($newTotal > 100) {
                Session::flash('success', 'Discount applied!');
                foreach ($cart as $item) {
                    $item->percentage = $percentageDiscount;
                    $item->save();
                }
                $request->session()->put('percent', $myPercentage);

            } else {
                Session::flash('error', 'Discount code is not eligible');
            }
        }else{
            Session::flash('error', 'Discount code does not exist');
        }

    // $request->session()->put('cart', $cart);
    return redirect()->back();
}





    public function forgetCart(Request $request){
        $userId = Auth::user()->id;
        $couponData = Coupon::all();
    
        $existCode = Coupon::first();

        $cart = Cart::where('user_id', $userId)->get();

        $myCode = $existCode ? $existCode->code : '';
        $myCoupon = $existCode ? $existCode->coupon : '';
        // dd($myCoupon);

        $discount = $existCode ? $existCode->discount : 0;
        $percentageDiscount = $existCode ? $existCode->percentage : 0;
    
        $newTotal = DB::table('cart')
            ->select('cart.*', 'clinical.image', 'clinical.head', 'clinical.price')
            ->where('user_id', $userId)
            ->join('clinical', 'clinical.id', '=', 'cart.product_id')
            ->sum(DB::raw('clinical.price * cart.quantity'));

            if ($existCode) {
                $request->session()->forget('code');
                $request->session()->forget('percent');
                foreach ($cart as $item) {
                    $item->discount = 0;
                    $item->percentage = 0;
                    $item->save();
                }
            }
        return redirect()->back();
    }
}


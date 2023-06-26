<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;
use App\Models\Bill;
use App\Models\Price;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function paymentController(Request $request){
        $userId = Auth::user()->id;
        $url = url('/billadd');
        $deliveryData = Delivery::where('user_id', $userId)->get();
        $request->session()->put('deliverData', $deliveryData);
        $billData = Bill::where('user_id', $userId)->orderBy('created_at','desc')->first();
        $title = 'Add New Address';

        $coupon = Coupon::first()->code;

        $cart = Cart::where('product_id', $request->input('product_id'))
        ->where('user_id', $userId)
        ->first();
       
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();
        // dd($item);
        $cartDiscount = $item->pluck('discount')->first();
        // dd($cartDiscount);
      
    
        $itemCount = $item->where('user_id',$userId)->count();

        // $NewtotalPrice = 0;
        foreach($item as $key=>$value){
            $item[$key]->totalPrice=$value->price * $value->quantity;
            // $NewtotalPrice = $NewtotalPrice + $item[$key]->totalPrice;
        }

        $newTotal = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));

        $finalTotal = $newTotal - $cartDiscount;

        $codeValue = $request->session()->get('code');
       if($cartDiscount > 1){
        $btnValue = 'Remove';
       }else{
        $btnValue = 'Apply';
       }

        
        $data = compact('item','deliveryData','newTotal','billData','url','title','itemCount','cart','finalTotal','codeValue','btnValue');
            return view('frontend/payment')->with($data);
        }

    public function billAdd(Request $request){
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'number' => 'required|numeric',
            'email' => 'required|email'
        ]);
        $userId = Auth::user()->id;
        $bill = new Bill;
        $bill->user_id = $userId;
        $bill->fname = $request->input('fname');
        $bill->lname = $request->input('lname');
        $bill->number = $request->input('number');
        $bill->email = $request->input('email');
        $bill->save();
        // dd($bill);
        return redirect()->back();
    }

    public function paymentEditController($id){
        $userId = Auth::user()->id;
        $deliveryData = Delivery::where('user_id',$userId)->get();
        // $coupon = Coupon::where('user_id', $userId)->get();
        $billData = Bill::where('user_id', $userId)->orderBy('created_at','desc')-first();
        $title = 'Update account here';
        $billDataNew = Bill::find($id);
        $cart = Cart::where('product_id', $request->input('product_id'))
        ->where('user_id', $userId)
        ->first();
        // dd($billData);
        $url = url('/editbilladd'.'/'.$id);
       
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();
        // dd($item);
        $cartDiscount = $item->pluck('discount')->first();
    
      $itemCount = $item->where('user_id',$userId)->count();
       
        // $NewtotalPrice = 0;
        foreach($item as $key=>$value){
            $item[$key]->totalPrice=$value->price * $value->quantity;
            // $NewtotalPrice = $NewtotalPrice + $item[$key]->totalPrice;
        }

        $newTotal = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));

        $finalTotal = $newTotal - $cartDiscount;


        $data = compact('item','deliveryData','newTotal','billDataNew','url','billData','title','itemCount','price','finalTotal');
        return view('frontend.payment', $data);
    }

    public function editbill($id, Request $request){
        $billValue = Bill::find($id);
        // dd($billValue);
        $billValue->fname = $request->input('fname');
        $billValue->lname = $request->input('lname');
        $billValue->number = $request->input('number');
        $billValue->email = $request->input('email');
        $billValue->save();
        return redirect()->back();
    }

    public function deleteBill($id){
        $delete = Bill::destroy($id);
        return redirect('/payment');
    }

    
}

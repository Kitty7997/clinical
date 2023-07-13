<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;

class DeliveryController extends Controller
{
    public function dealControl(Request $request)
{
    $cart = (new Cart())->cartData();

    if ($cart->isEmpty()) {
        return redirect('/');
    }
    
    $userId = Auth::user()->id;

    $overallTotal = $cart->sum('totalPrice');

    $couponCode = $cart[0]->voucher;
    
    if($couponCode){
        $coupon = (new Coupon())->getCoupon($couponCode);

        $totalAmount = $coupon['totalValue'];

        $couponDiscount = $coupon['discount'];

        $btnValue = 'Remove';
        $myUrl = url('/forget');
    }else{
        $totalAmount = $overallTotal;
        $couponDiscount = 0;

        $btnValue = 'Apply';
        $myUrl = url('/apply_coupon');
    }

    $deliveryData = Delivery::where('user_id', $userId)->orderBy('created_at', 'desc')->first();

    $url = url('/postdelivery');

    $itemCount = $cart->where('user_id', $userId)->count();

    $data = compact('cart', 'deliveryData', 'url', 'itemCount','totalAmount','myUrl','couponDiscount');

    return view('frontend.delivery', $data);
}


    public function addData(Request $request){
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required|numeric',
            'street' => 'required',
            'flat' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postcode' => 'required|numeric'
        ]);
    
        $userId = Auth::user()->id;
        
            $delivery = new Delivery;
            $delivery->user_id = $userId;
            $delivery->fname = $request->input('fname');
            $delivery->lname = $request->input('lname');
            $delivery->phone = $request->input('phone');
            $delivery->street = $request->input('street');
            $delivery->flat = $request->input('flat');
            $delivery->city = $request->input('city');
            $delivery->country = $request->input('country');
            $delivery->postcode = $request->input('postcode');
            
            $delivery->save();
         return redirect('/payment');
    }
    

    public function deleteData($id){
        $delData = Delivery::destroy($id);
        return redirect()->back();
    }


    public function editData($id){
        $userId = Auth::user()->id;

        $deliveryData = Delivery::where('user_id', $userId)->orderBy('created_at','desc')->first();

        $editData = Delivery::find($id);

        $cart = (new Cart())->cartData();

        $overallTotal = $cart->sum('totalPrice');

        $couponCode = $cart[0]->voucher;
    
        if($couponCode){
            $coupon = (new Coupon())->getCoupon($couponCode);
    
            $totalAmount = $coupon['totalValue'];
    
            $couponDiscount = $coupon['discount'];
    
            $btnValue = 'Remove';
            $myUrl = url('/forget');
        }else{
            $totalAmount = $overallTotal;
            $couponDiscount = 0;
    
            $btnValue = 'Apply';
            $myUrl = url('/apply_coupon');
        }
       
        $url = url('/update').'/'. $id;
    
        $itemCount = $cart->where('user_id',$userId)->count();


       $data = compact('url','cart','overallTotal','editData','deliveryData','itemCount','totalAmount','myUrl','couponDiscount');
       return view('frontend/delivery')->with($data);
    }


    public function updateData($id, Request $request){
        $userId = Auth::user()->id;
        $updateData = Delivery::find($id);
        $updateData->user_id = $userId;
        $updateData->fname = $request->input('fname');
        $updateData->lname = $request->input('lname');
        $updateData->phone = $request->input('phone');
        $updateData->street = $request->input('street');
        $updateData->flat = $request->input('flat');
        $updateData->city = $request->input('city');
        $updateData->country = $request->input('country');
        $updateData->postcode = $request->input('postcode');
        $updateData->save();
        return redirect('/delivery');
    }

}

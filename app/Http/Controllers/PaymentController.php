<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Bill;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function paymentController(Request $request)
    {
        $userId = Auth::user()->id;
        $cart = (new Cart())->cartData();
        $deliveryData = Delivery::where('user_id', $userId)->orderBy('created_at','desc')->first();

        if (!$deliveryData) {
            return redirect('/delivery');
        }

        $url = url('/billadd');


        $billData = Bill::where('user_id', $userId)->orderBy('created_at', 'desc')->first();

        $title = 'Add New Address';

        $cart = (new Cart())->cartData();

        $itemCount = $cart->where('user_id', $userId)->count();

        $overallTotal = $cart->sum('totalPrice');

        $couponCode = $cart[0]->voucher;

        if ($couponCode) {
            $coupon = (new Coupon())->getCoupon($couponCode);

            $totalAmount = $coupon['totalValue'];

            $couponDiscount = $coupon['discount'];

            $btnValue = 'Remove';
            $myUrl = url('/forget');
        } else {
            $totalAmount = $overallTotal;
            $couponDiscount = 0;

            $btnValue = 'Apply';
            $myUrl = url('/apply_coupon');
        }

        $data = compact('cart','deliveryData','totalAmount','url','title','myUrl','couponDiscount','itemCount','billData');

        return view('frontend/payment')->with($data);
    }

    public function billAdd(Request $request)
    {
    //   $request->validate([
    //     'fname' => 'required',
    //     'lname' => 'required',
    //     'number' => 'required|numeric',
    //     'email' => 'required|email'
    //   ]);
    
      $userId = Auth::user()->id;
      
        $bill = new Bill;
        $bill->user_id = $userId;
        $bill->fname = $request->input('fname');
        $bill->lname = $request->input('lname');
        $bill->number = $request->input('number');
        $bill->email = $request->input('email');
        $bill->save();
    
    
      return response()->json(['bill' => $bill]);
    }
    

    public function paymentEditController($id, Request $request)
    {
        $userId = Auth::user()->id;
        $deliveryData = Delivery::where('user_id', $userId)->get();

        $title = 'Update account here';

        $billDataNew = Bill::find($id);

        $url = url('/editbilladd' . '/' . $id);

        $cart = (new Cart())->cartData();

        $itemCount = $cart->where('user_id', $userId)->count();

        $newTotal = $cart->sum('totalPrice');

        $data = compact('cart', 'deliveryData', 'newTotal', 'billDataNew', 'url', 'title', 'itemCount');
        return view('frontend.payment', $data);
    }

    public function editbill($id, Request $request)
    {
        $billValue = Bill::find($id);

        $billValue->fname = $request->input('fname');
        $billValue->lname = $request->input('lname');
        $billValue->number = $request->input('number');
        $billValue->email = $request->input('email');
        $billValue->save();
        return redirect()->back();
    }

    public function deleteBill($id)
    {
        $userId = Auth::user()->id;
        $bill = Bill::where('user_id', $userId)->orderBy('created_at', 'desc')->first();
        $delete = Bill::destroy($id);
        return response()->json([
            'bill' => $bill
        ]);
    }
}

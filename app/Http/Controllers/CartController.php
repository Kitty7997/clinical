<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Clinical;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        $userId = Auth::user()->id;

        $cart = Cart::where('user_id', $userId)->first();

        if ($cart) {
            $productIds = explode(',', $cart->product_id);

            if (!in_array($request->input('id'), $productIds)) {
                $productIds[] = $request->input('id');
                sort($productIds);
                $cart->product_id = implode(',', $productIds);
                $cart->save();
            }
        } else {
            $cart = new Cart;
            $cart->product_id = $request->input('id');
            $cart->user_id = $userId;
            $cart->save();
        }

        $cartItem = (new Cart())->cartData();

        $overallTotal = $cartItem->sum('totalPrice');

        return response()->json(['count' => $cartItem->count(), 'cart' => $cartItem, 'total' => $overallTotal]);
    }




    public function viewCart(Request $request)
    {
        $userId = Auth::id();

        $clinicaldata = Clinical::take(2)->get();

        $cart = (new Cart())->cartData();
        // dd($cart);

        $overallTotal = $cart->sum('totalPrice');

        $itemCount = $cart->where('user_id', $userId)->count();

        $data = compact('cart', 'itemCount', 'clinicaldata', 'overallTotal');

        return view('frontend/cart')->with($data);
    }




    public function removeData($id)
    {
        $userId = Auth::user()->id;
    
        $cart = Cart::where('user_id', $userId)->first();
       
        $productIds = explode(',', $cart->product_id);
    
        $removeItem = explode(',', $id);
    
        $updatedProductIds = array_diff($productIds, $removeItem);
    
        $cart->product_id = implode(',', $updatedProductIds);
    
        $cart->save();
    
        $cartItem = (new Cart())->cartData();

        $totalAmount = $cartItem->sum('totalPrice');

        $productIds = $updatedProductIds;
    
        $couponCode = $cart->voucher;
    
        if ($couponCode) {
            $coupon = (new Coupon())->getCoupon($couponCode);
            $totalAmount = $coupon['totalValue'];
        } 

        if($totalAmount < 100){
            $cart->voucher = '';
            $cart->discount = 0;
            $cart->save();
            $totalAmount = $cartItem->sum('totalPrice');
        }
    
        
        if (empty($productIds)) {
            $cart->delete();
        }
    
        return response()->json([
            'total' => $totalAmount,
            'count' => $cartItem->count(),
        ]);
    }
    
    




    public function applyCoupon(Request $request)
    {
        $userId = Auth::user()->id;

        $cart = Cart::where('user_id', $userId)->get();

        $items = (new Cart())->cartData();

        $totalPrice = $items->sum('totalPrice');

        $couponCode = $request->input('code');

        $couponItem = (new Coupon())->getCoupon($couponCode);

        $couponDiscount = explode(',', $couponItem['discount']);

        if ($totalPrice >= 100) {
            foreach ($cart as $item) {
                $item->discount = $couponDiscount[0];
                $item->voucher = $request->input('code');
                $item->save();
            }
        } else {
                $cart->discount = 0;
                $cart->voucher = '';
                $cart->save();
        }

        if ($couponItem > 0) {
            $btnValue = 'Remove';
            $myUrl = url('/forget');
        } else {
            $btnValue = 'Apply';
            $myUrl = url('/apply_coupon');
        }

        return response()->json([
            'inputData' => $request->input('code'),
            'myUrl' => $myUrl,
            'btnValue' => $btnValue,
            'total' => $couponItem['totalValue'],
            'discount' => $couponDiscount[0],
        ]);
    }




    public function forgetCart()
    {
        $userId = Auth::user()->id;

        $cart = Cart::where('user_id', $userId)->get();
       
        $item = (new Cart())->cartData();

        $newTotal = $item->sum('totalPrice');

        if ($cart) {
            foreach($cart as $item){
            $item->discount = 0;
            $item->voucher = '';
            $item->save();
            }
    }
        return response()->json([
            'total' => $newTotal,
            'btnValue' => 'Apply',
        ]);
    }
}

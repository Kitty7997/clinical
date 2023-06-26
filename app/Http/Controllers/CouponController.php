<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Cart;
use Carbon\Carbon;
use App\Models\Price;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CouponController extends Controller
{
// public function couponApply(Request $request)
// {
//     $userId = Auth::user()->id;
//     $existCode = Coupon::where('code', $request->input('code'))->first();
//     $discount = $existCode ? $existCode->discount : 0;
//     dd($discount);
//     $cart = Cart::where('product_id', $request->input('product_id'))
//     ->where('user_id', $userId)
//     ->first();

//     if ($existCode) {
//         $newTotal = DB::table('cart')
//             ->select('cart.*', 'clinical.image', 'clinical.head', 'clinical.price')
//             ->where('user_id', $userId)
//             ->join('clinical', 'clinical.id', '=', 'cart.product_id')
//             ->sum(DB::raw('clinical.price * cart.quantity'));
//             dd($newTotal);

//         if ($newTotal > 100) {
//             $newDiscountedPrice = $newTotal - $discount;

//             $cart->discount = $discount;

//             Session::flash('success', 'Coupon applied!');
//             return redirect()->back();
//         } else {
//             Session::flash('error', 'Total amount is not sufficient for discount');
//             return redirect()->back();
//         }
//     } else {
//         Session::flash('error', 'Coupon does not exist!');
//         return redirect()->back();
//     }
// }


}

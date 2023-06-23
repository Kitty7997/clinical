<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;
use App\Models\Price;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CouponController extends Controller
{
//     public function couponApply(Request $request)
// {
//     $userId = Auth::user()->id;
//     $existingCoupon = Coupon::where('user_id', $userId)
//     ->where('code', $request->input('code'))
//     ->first();
//     //  dd($existingCoupon);

//     if ($existingCoupon) {
//         Session::flash('error', 'Coupon already applied!');
//         return redirect()->back();
//     } else {

//         $coupon = new Coupon;
//         $coupon->user_id = $userId;
//         $coupon->code = strtoupper($request->input('code'));
//         $coupon->expiration_date = Carbon::now()->addDays(7)->format('Y-m-d');
//         $coupon->save();
//         // dd($coupon);

//         $newTotal = DB::table('cart')
//         ->select('cart.*','clinical.image','clinical.head','clinical.price')
//         ->where('user_id', $userId)
//         ->join('clinical', 'clinical.id', '=', 'cart.product_id')
//         ->sum(DB::raw('clinical.price * cart.quantity'));

//         // $request->session()->put('coupon', $coupon);

//         Session::flash('success', 'Coupon applied!');
//         $discountPrice = 35;
//         $newDiscountedPrice = $newTotal - $discountPrice;
//         // dd($newDiscountedPrice);
//         $request->session()->put('newDiscountedPrice',$newDiscountedPrice);
//         return redirect()->back();
//     }
// }

    public function couponApply(Request $request){
        $userId = Auth::user()->id;
        $existCode = Coupon::where('code', $request->input('code'))->first();
        $discount = $existCode ? $existCode->discount : 0;
        // dd($discount);

        if($existCode){
            $newTotal = DB::table('cart')
            ->select('cart.*','clinical.image','clinical.head','clinical.price')
            ->where('user_id', $userId)
            ->join('clinical', 'clinical.id', '=', 'cart.product_id')
            ->sum(DB::raw('clinical.price * cart.quantity'));

            
            if($newTotal > 100){
                $newDiscountedPrice = $newTotal - $discount;
                // dd($newDiscountedPrice);
                Session::flash('success', 'Coupon applied!');
                // $request->session()->put('discountPrice', $newDiscountedPrice);
                
                // $a = $request->session()->get('discountPrice');
                // dd($a);
                // return redirect()->back()->with(['discountPrice', $newDiscountedPrice]);   
            }else{
                $newDiscountedPrice = $newTotal;
                Session::flash('error', 'Total Amount is not sufficient for discount');
                // return redirect()->back()->with(['discountPrice', $newDiscountedPrice]);
            }

        }else{
            Session::flash('error', 'Coupon does not exist!');
            return redirect()->back();
        }
    }

}

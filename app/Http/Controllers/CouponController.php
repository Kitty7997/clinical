<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;


class CouponController extends Controller
{
    public function couponApply(Request $request){
        $coupon = new Coupon;
        $coupon->code = $request->input('code');
        $coupon->expiration_date = Carbon::now()->addDays(7)->format('Y-m-d');
        $coupon->save();
        return redirect()->back();
    }
}

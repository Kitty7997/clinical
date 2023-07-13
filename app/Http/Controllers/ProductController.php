<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinical;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
   public function ClinicalRoute(Request $request){
    $clinicaldata = Clinical::all();
    $cartData = Cart::all();

    $userId = Auth::user()->id;

    $item = (new Cart())->cartData();

    $overallTotal = $item->sum('totalPrice');
    
    $itemCount = $item->where('user_id',$userId)->count();

    $data = compact('clinicaldata','item','cartData','itemCount');
    return view('frontend/clinical')->with($data);
   }

}

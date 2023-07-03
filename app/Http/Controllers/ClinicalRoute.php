<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinical;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ClinicalRoute extends Controller
{
   public function ClinicalRoute(Request $request){
    $clinicaldata = Clinical::all();
    $cartData = Cart::all();

    $userId = Auth::user();
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
    
    $cart = $request->session()->get('item');

    $data = compact('clinicaldata','item','cart','cartData','itemCount');
    return view('frontend/clinical')->with($data);
   }

}

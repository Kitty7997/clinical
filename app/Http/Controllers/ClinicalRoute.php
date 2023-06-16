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

    $item = DB::table('cart')
      ->select('cart.*','clinical.image','clinical.head','clinical.price')
      ->join('clinical', 'clinical.id', '=', 'cart.product_id')
      ->get();
    $cart = $request->session()->get('item');

    $data = compact('clinicaldata','item','cart');
    return view('frontend/clinical')->with($data);
   }

}

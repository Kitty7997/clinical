<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Clinical;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class AddonController extends Controller
{
    public function addOn(){
        $clinicaldata = Clinical::all();
        $userId = Auth::user();
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId->id)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();

        // $NewtotalPrice = 0;
        foreach($item as $key=>$value){
            $item[$key]->totalPrice=$value->price * $value->quantity;
            // $NewtotalPrice = $NewtotalPrice + $item[$key]->totalPrice;
        }

        $newTotal = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId->id)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));
        $itemCount = $item->where('user_id',$userId->id)->count();
        $data = compact('item','clinicaldata','newTotal','itemCount');
        return view('frontend/addons')->with($data);
    }
}

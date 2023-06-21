<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function dealControl(){
        $userId = Auth::user()->id;
        $deliveryData = Delivery::where('user_id', $userId)->get();
        // dd($deliveryData);
        $url = url('/postdelivery');
        $item = null;
        $itemCount = 0;
        if($userId){
          $item = DB::table('cart')
          ->select('cart.*','clinical.image','clinical.head','clinical.price')
          ->where('user_id', $userId)
          ->join('clinical', 'clinical.id', '=', 'cart.product_id')
          ->get();
          // dd($item);
        
          $itemCount = $item->where('user_id',$userId)->count();
        }

        // $NewtotalPrice = 0;
        foreach($item as $key=>$value){
            $item[$key]->totalPrice=$value->price * $value->quantity;
            // $NewtotalPrice = $NewtotalPrice + $item[$key]->totalPrice;
        }

        $newTotal = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));
       

        $data = compact('item','newTotal','deliveryData','url','itemCount');
        return view('frontend/delivery')->with($data);
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
        $existingDelivery = Delivery::where('user_id', $userId)
                                    ->where('street', $request->input('street'))
                                    ->where('flat', $request->input('flat'))
                                    ->where('city', $request->input('city'))
                                    ->where('country', $request->input('country'))
                                    ->where('postcode', $request->input('postcode'))
                                    ->first();
    
        if ($existingDelivery) {
            $request->session()->put('addressData', $existingDelivery);
        } else {
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
        }

        return redirect('/payment');
    }
    

    public function deleteData($id){
        $delData = Delivery::destroy($id);
        return redirect()->back();
    }

    public function editData($id){
       $deliveryData = Delivery::all();
       $editData = Delivery::find($id);
       $userId = Auth::user();
       
       $url = url('/update').'/'. $id;
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

        foreach($item as $key=>$value){
            $item[$key]->totalPrice=$value->price * $value->quantity;
        }

        $newTotal = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId->id)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));


       $data = compact('url','item','newTotal','editData','deliveryData','itemCount');
       return view('frontend/delivery')->with($data);
    }

    public function updateData($id, Request $request){
        $userId = Auth::user()->id;
        $updateData = Delivery::find($id);
        $delivery->user_id = $userId;
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

    public function continueData($id, Request $request){
        $continueData = Delivery::find($id); 
        // $request->session()->put('shipData', $continueData);
        $data = compact('continueData');
        return redirect('/payment')->with($data);
    }

}

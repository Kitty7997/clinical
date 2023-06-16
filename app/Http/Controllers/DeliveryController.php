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
        $deliveryData = Delivery::all();
        // dd($deliveryData);
        $url = url('/postdelivery');
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();

        // $NewtotalPrice = 0;
        foreach($item as $key=>$value){
            $item[$key]->totalPrice=$value->price * $value->quantity;
            // $NewtotalPrice = $NewtotalPrice + $item[$key]->totalPrice;
        }

        $newTotal = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));
       
        $data = compact('item','newTotal','deliveryData','url');
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

        $delivery = new Delivery;
        $delivery->fname = $request->input('fname');
        $delivery->lname = $request->input('lname');
        $delivery->phone = $request->input('phone');
        $delivery->street = $request->input('street');
        $delivery->flat = $request->input('flat');
        $delivery->city = $request->input('city');
        $delivery->country = $request->input('country');
        $delivery->postcode = $request->input('postcode');
        $delivery->save();
        return redirect('/payment');
    }

    public function deleteData($id){
        $delData = Delivery::destroy($id);
        return redirect()->back();
    }

    public function editData($id){
       $deliveryData = Delivery::all();
       $editData = Delivery::find($id);
       
       $url = url('/update').'/'. $id;
       $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();

        foreach($item as $key=>$value){
            $item[$key]->totalPrice=$value->price * $value->quantity;
        }

        $newTotal = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));

       $data = compact('url','item','newTotal','editData','deliveryData');
       return view('frontend/delivery')->with($data);
    }

    public function updateData($id, Request $request){
        $updateData = Delivery::find($id);
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

    public function continueData($id){
        $continueData = Delivery::find($id);
        $data = compact('continueData');
        return redirect('/payment')->with($data);
    }

}
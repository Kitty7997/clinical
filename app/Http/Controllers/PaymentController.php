<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function paymentController(){
        $url = url('/billadd');
        $deliveryData = Delivery::all();
        $billData = Bill::all();
        $title = 'Add New Address';
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

        $data = compact('item','deliveryData','newTotal','billData','url','title');
        return view('frontend/payment')->with($data);
        }

    public function billAdd(Request $request){
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'number' => 'required|numeric',
            'email' => 'required|email'
        ]);

        $bill = new Bill;
        $bill->fname = $request->input('fname');
        $bill->lname = $request->input('lname');
        $bill->number = $request->input('number');
        $bill->email = $request->input('email');
        $bill->save();
        // dd($bill);
        return redirect()->back();
    }

    public function paymentEditController($id){
        $user = Auth::user()->id;
        $deliveryData = Delivery::all();
        $billData = Bill::all();
        $title = 'Update account here';
        $billDataNew = Bill::find($id);
        // dd($billData);
        $url = url('/editbilladd'.'/'.$id);
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

        $data = compact('item','deliveryData','newTotal','billDataNew','url','billData','title');
        return view('frontend/payment')->with($data);
    }

    public function editbill($id, Request $request){
        $billValue = Bill::find($id);
        // dd($billValue);
        $billValue->fname = $request->input('fname');
        $billValue->lname = $request->input('lname');
        $billValue->number = $request->input('number');
        $billValue->email = $request->input('email');
        $billValue->save();
        return redirect()->back();
    }

    public function deleteBill($id){
        $delete = Bill::destroy($id);
        return redirect('/payment');
    }

    
}

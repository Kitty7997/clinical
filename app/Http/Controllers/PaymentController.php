<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function paymentController(Request $request){
        $userId = Auth::user()->id;
        $url = url('/billadd');
        $deliveryData = Delivery::where('user_id', $userId)->get();
        $request->session()->put('deliverData', $deliveryData);
        $billData = Bill::where('user_id', $userId)->get();
        $title = 'Add New Address';
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


        $data = compact('item','deliveryData','newTotal','billData','url','title','itemCount');
            return view('frontend/payment')->with($data);
        }

    public function billAdd(Request $request){
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'number' => 'required|numeric',
            'email' => 'required|email'
        ]);
        $userId = Auth::user()->id;
        $bill = new Bill;
        $bill->user_id = $userId;
        $bill->fname = $request->input('fname');
        $bill->lname = $request->input('lname');
        $bill->number = $request->input('number');
        $bill->email = $request->input('email');
        $bill->save();
        // dd($bill);
        return redirect()->back();
    }

    public function paymentEditController($id){
        $userId = Auth::user()->id;
        $deliveryData = Delivery::where('user_id',$userId)->get();

        $billData = Bill::where('user_id', $userId)->get();
        $title = 'Update account here';
        $billDataNew = Bill::find($id);
        // dd($billData);
        $url = url('/editbilladd'.'/'.$id);
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


        $data = compact('item','deliveryData','newTotal','billDataNew','url','billData','title','itemCount');
        return view('frontend.payment', $data);
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

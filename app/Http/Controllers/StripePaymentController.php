<?php
    
namespace App\Http\Controllers;
     
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\User;
use App\Models\Orders;
use App\Models\Bill;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentMethod;
use Stripe\PaymentIntent;
use Stripe\Exception\CardException;
use Illuminate\Support\Facades\env;
     
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {   $userId = Auth::user();
        
        $item = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id', $userId->id)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->get();
        // dd($item);
    
      $itemCount = $item->where('user_id',$userId->id)->count();
    
        $total = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->where('user_id',$userId->id)
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));
        $data = compact('item','total');
        return view('frontend/stripe')->with($data);
    }
    
    
    public function stripePost(Request $request)
    {
        try {
            
            Stripe::setApiKey(env('STRIPE_SECRET'));
    
            
            $userId = Auth::user()->id;
            $bill = Bill::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->first();
            // dd($bill);
            $newTotal = DB::table('cart')
                ->select('cart.*', 'clinical.image', 'clinical.head', 'clinical.price')
                ->where('user_id', $userId)
                ->join('clinical', 'clinical.id', '=', 'cart.product_id')
                ->sum(DB::raw('clinical.price * cart.quantity'));
    
            $items = DB::table('cart')
                ->select('cart.*', 'clinical.image', 'clinical.head', 'clinical.price')
                ->where('user_id', $userId)
                ->join('clinical', 'clinical.id', '=', 'cart.product_id')
                ->get();
    
            foreach ($items as $item) {
                $item->totalPrice = $item->price * $item->quantity;
            }
    
            $address = $request->session()->get('addressData');
            //  dd($address);

            if ($request->has('stripeToken')) {
                
                $paymentMethod = PaymentMethod::create([
                    'type' => 'card',
                    'card' => [
                        'token' => $request->stripeToken,
                    ],
                    // 'billing_details' => [
                    //     'email' => $bill->email,
                    //     'name' => $bill->fname,
                    //     'phone' => $bill->number,
                    //     ],
                ]);
                
                // dd($paymentMethod);
                $paymentIntent = PaymentIntent::create([
                    'amount' => $newTotal * 100,
                    'currency' => 'usd',
                    'payment_method' => $paymentMethod->id,
                    'description' => 'Test payment',
                    'confirm' => true,
                    "shipping" => [
                        "name" => $address ->fname,
                        "address" => [
                            "line1" => $address->phone,
                            "postal_code" => $address->postcode,
                            "city" => $address->city,
                            "state" => $address->street,
                        ],
                    ],
                ]);

                
                if ($paymentIntent->status === 'requires_action' && $paymentIntent->next_action->type === 'use_stripe_sdk') {
                    
                    $clientSecret = $paymentIntent->client_secret;
                   
                    return response()->json(['requires_action' => true, 'client_secret' => $clientSecret]);
                } elseif ($paymentIntent->status === 'succeeded') {
                    foreach ($items as $product) {
                        $order = new Orders;
                        $order->user_id = $address->user_id;
                        $order->order_id = $paymentIntent->id;
                        $order->amount = $product->price;
                        $order->payment_method_type = json_encode($paymentIntent->payment_method_types);
                        $order->status = $paymentIntent->status;
                        $order->product_image = $product->image;
                        $order->product_head = $product->head;
                        $order->quantity = $product->quantity;
                        $order->total = $product->totalPrice;
                        $order->address = json_encode($paymentIntent->shipping->address->city);
                        $order->save();
                    }
    
                    Cart::where('user_id', $userId)->delete();
                    Session::flash('success', 'Your order has been placed!');
                    return redirect('/order');
                } else {
                    
                    return response()->json(['error' => 'Payment failed.']);
                }
            } else {
                Session::flash('error', 'No payment method provided. Your order has been cancelled.');
                return redirect('/cart');
            }
        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred during payment. Please try again.']);
        }
    }
    

}
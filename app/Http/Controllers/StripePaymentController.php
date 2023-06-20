<?php
    
namespace App\Http\Controllers;
     
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\User;
use App\Models\Orders;
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
            // Set the Stripe API key
            Stripe::setApiKey(env('STRIPE_SECRET'));
            // Stripe::getApiKey();
            
            // Retrieve the authenticated user's ID
            $userId = Auth::user()->id;
            $newTotal = DB::table('cart')
                ->select('cart.*','clinical.image','clinical.head','clinical.price')
                ->where('user_id', $userId)
                ->join('clinical', 'clinical.id', '=', 'cart.product_id')
                ->sum(DB::raw('clinical.price * cart.quantity'));

                $item = DB::table('cart')
                ->select('cart.*','clinical.image','clinical.head','clinical.price')
                ->where('user_id', $userId)
                ->join('clinical', 'clinical.id', '=', 'cart.product_id')
                ->get();
           
                foreach($item as $key=>$value){
                    $item[$key]->totalPrice=$value->price * $value->quantity;
                    // $NewtotalPrice = $NewtotalPrice + $item[$key]->totalPrice;
                }
        
               
                
            // Retrieve the user's delivery address from the 'delivery' table
            $address = DB::table('delivery')->where('user_id', $userId)->first();
            // dd($address);
            // Check if a payment method has been provided
            if ($request->has('stripeToken')) {
                // Create a payment method using the provided stripeToken
                $paymentMethod = PaymentMethod::create([
                    'type' => 'card',
                    'card' => [
                        'token' => $request->stripeToken,
                    ],
                ]);
    
                // Create a payment intent with the provided payment method
                $paymentIntent = PaymentIntent::create([
                    'amount' => $newTotal * 100, 
                    'currency' => 'usd', 
                    'payment_method' => $paymentMethod->id,
                    'description' => 'Test payment',
                    'confirm' => true,
                ]);
                // dd($paymentIntent);
                // Handle payment intent status
                if ($paymentIntent->status === 'requires_action' && $paymentIntent->next_action->type === 'use_stripe_sdk') {
                    // The payment requires additional authentication
                    $clientSecret = $paymentIntent->client_secret;
                    // Pass the client secret to the client-side JavaScript code to complete the authentication
                    return response()->json(['requires_action' => true, 'client_secret' => $clientSecret]);
                } elseif ($paymentIntent->status === 'succeeded') {
                    foreach ($item as $product) {
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
                        $order->save();
                    }
                    Cart::where('user_id', $userId)->delete();
                    Session::flash('success', 'Your order has been placed!');
                    return redirect('/order');
                } else {
                    // Handle other payment statuses or errors
                    return response()->json(['error' => 'Payment failed.']);
                }
            } else {
                // Handle case when no payment method is provided
                Session::flash('error', 'No payment method provided. Your order has been cancelled.');
                return redirect('/cart');
            }
        } catch (Exception $e) {
            // Handle any exceptions that occurred during the payment process
            return response()->json(['error' => 'An error occurred during payment. Please try again.']);
        }
    }

}
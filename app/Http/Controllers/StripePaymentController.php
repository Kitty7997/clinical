<?php
    
namespace App\Http\Controllers;
     
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentMethod;
use Stripe\PaymentIntent;
     
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {   $userId = Auth::user();
        
        $item = (new Cart())->cartData();
        
        $itemCount = $item->where('user_id',$userId->id)->count();
    
        $total = $item->sum('totalPrice');
        $data = compact('item','total');
        return view('frontend/stripe')->with($data);
    }
    
    
    public function stripePost(Request $request)
    {
            Stripe::setApiKey(env('STRIPE_SECRET'));
    
            $userId = Auth::user()->id;

            $items = (new Cart())->cartData();

            $newTotal = $items->sum('totalPrice');
    
            // $cartDiscount = $items->pluck('discount')->first();
            // $cartPercentage = $items->pluck('percentage')->first();
    
            // $finalTotal = $newTotal - $cartDiscount;
            // $finalTotal2 = $newTotal - ($newTotal * $cartPercentage / 100);
    
            // $totalValue = $cartDiscount ? $finalTotal : $finalTotal2;
            // $totalDiscount = $cartDiscount ? $cartDiscount : $cartPercentage;

            $address = Delivery::where('user_id', $userId)->first();
    
            if ($request->has('stripeToken')) {
                $paymentMethod = PaymentMethod::create([
                    'type' => 'card',
                    'card' => [
                        'token' => $request->stripeToken,
                    ],
                ]);
    
                $paymentIntent = PaymentIntent::create([
                    'amount' => $newTotal * 100,
                    'currency' => 'usd',
                    'payment_method' => $paymentMethod->id,
                    'description' => 'Test payment',
                    'confirm' => true,
                    "shipping" => [
                        "name" => $address->fname,
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
                        $order->discount = 35;
                        $order->paid_amount = 263;
                        $order->address = json_encode($paymentIntent->shipping->address->city);
                        $order->save();
                    }
    
                    Cart::where('user_id', $userId)->delete();
                    $request->session()->forget('code');
                    $request->session()->forget('percent');
                    Session::flash('success', 'Your order has been placed!');
                    return redirect('/order');
                } else {
                    return response()->json(['error' => 'Payment failed.']);
                }
            } else {
                Session::flash('error', 'No payment method provided. Your order has been cancelled.');
                return redirect('/cart');
            }
    }
    
    

}
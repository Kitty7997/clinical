<?php
    
namespace App\Http\Controllers;
     
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Cart;
use App\Models\User;
use Stripe;
use Illuminate\Support\Facades\DB;
     
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $total = DB::table('cart')
        ->select('cart.*','clinical.image','clinical.head','clinical.price')
        ->join('clinical', 'clinical.id', '=', 'cart.product_id')
        ->sum(DB::raw('clinical.price * cart.quantity'));
        $data = compact('total');
        return view('frontend/stripe')->with($data);
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
{
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    $paymentMethod = Stripe\PaymentMethod::create([
        'type' => 'card',
        'card' => [
            'token' => $request->stripeToken,
        ],
    ]);

    Stripe\PaymentIntent::create([
        "amount" => 100 * 100,
        "currency" => "usd",
        "payment_method" => $paymentMethod->id,
        // "description" => "Test payment from itsolutionstuff.com." 
    ]);
    $user = Auth::user()->id;
    dd($user);
    Cart::where('product_id', Auth::user()->id)->delete();
    

            Session::flash('success', 'Your order has been placed!');
            return redirect('/');

    }
}
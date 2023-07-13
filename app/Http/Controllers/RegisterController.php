<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;




class RegisterController extends Controller
{
    
    public function accountPage(){
        $userId = Auth::user();

        $item = (new Cart())->cartData();
       
        $itemCount = $item->where('user_id',$userId->id)->count();
    
        $data = compact('item','itemCount');

        return view('frontend/account')->with($data);
    }



    public function postLogin(Request $request)
    {
    $request->validate([
        'fname' => 'required',
        'lname' => 'required',
        'phone' => 'required|numeric',
        'email' => 'required|email|unique:users',
        'password'  => 'required|min:8',
        'confirmpassword' => 'required|same:password'
    ]);

    $user = new User;
    $user->fname = $request->input('fname');
    $user->lname = $request->input('lname');
    $user->phone = $request->input('phone');
    $user->email = $request->input('email');
    $user->password = Hash::make($request->input('password'));
    $user->confirmpassword = Hash::make($request->input('confirmpassword'));
    $user->save();

    return redirect('login');
    }




    public function loginPage(){
        $userId = Auth::user();
       
        $item = (new Cart())->cartData();
    
        // $itemCount = $item->where('user_id',$userId->id)->count();
    
        $data = compact('item');

        return view('frontend/login')->with($data);
    }

    public function loginPost(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $userData = $request->only('email', 'password');
        
        if(Auth::attempt($userData)){
            $request->session()->put('userData', $userData);
            return redirect('/');
        }else{
            return redirect()->back()->withErrors(['password' => 'Either email or password is wrong.']);
        }
    }
    
    public function forgotPassword(){
        $userId = Auth::user();
       
          $item = (new Cart())->cartData();
        
          $itemCount = $item->where('user_id',$userId->id)->count();
        
        $data = compact('item','itemCount');

        return view('frontend/forgot')->with($data);
    }



    
   public function postforgot(Request $request){
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
    }
 
    public function logout(Request $request) {
      $request->session()->forget('userData');
      return redirect()->back();
    }
    
    public function resetPassword(string $token){
        return view('frontend/reset', ['token' => $token]);
    }

}

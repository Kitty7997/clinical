@include('frontend.header')

<div class="container">
    <div class="forgot_box">
        <h1>Please enter your email address</h1>
        <p><i>We will send you a link through email</i></p>
       <form action="{{url('/forgot-password')}}" method="post">
        @csrf
        @if(session('status'))
        <span class="text-success">{{session('status')}}</span>
        @endif
        <span class="text-danger">
         @error('email')
         {{$message}}
         @enderror
        </span>
        <input type="email" name='email' placeholder="Enter your email" class="forgot_input">
        <a href="{{url('/reset-password/{token}')}}"><button class="reset_button button"><b>Send Verification Link</b></button></a>
       </form>
    </div>
</div>
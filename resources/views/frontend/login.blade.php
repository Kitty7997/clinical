@include('frontend/header')


<!-- <iframe class="common_header" src="../pages/header.html"></iframe> -->
@if($errors->any())
    <div class="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="login-sec">
	<div class="container">
		<div class="heading_text">
			<h2>Log in</h2>
			<p>Please enter your details</p>
		</div>
		<div class="signin_btn">
			<button type="button"><img class="apple_icon" src="../images/apple.svg"> Sign up with Apple</button>
		</div>
		<a href="{{ url('auth/google') }}" class="text-decorate">
		<div class="signin_btn google_signin">
			<button type="button"><img class="apple_icon" src="../images/google.svg"> Sign in with Google</button>
		</div>
		</a>
		<p class="or_option">or</p>
		<form class="account_form" action="{{url('/postlogin')}}" method="post">
			@csrf
			<div class="inner_name">
		  <label class="form_label" for="email">Email
		  <input type="text" id="email" name="email">
		  <span class="text-danger mt-0">
			@error('email')
				{{$message}}
			@enderror
		  </span>
		  <a class="forgot_pwd" href="{{url('/forgot-password')}}">Forgot Password</a>
		  </label>
		  <label class="form_label" for="pwd">Password
          <input class="password" type="password" id="pwd" name="password">
		  <span class="text-danger">
			@error('password')
				{{$message}}
			@enderror
		  </span>
          </label>
		  </div>
		  <div class="assesment_button">
				<button class="button">Sign in</button>
		  </div>
		  <p class="enter_details">Please enter your details <a class="signup_here" href="{{url('/register')}}">Sign up for here</a></p>
		</form>
	</div>
	
</section>

</body>
</html>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript">
  $(document).ready(function () {
      $('a.test_step')
              .click(function (e) {
          $('a.test_step')
              .removeClass("active");
          $(this).addClass("active");
      });
  });
</script>
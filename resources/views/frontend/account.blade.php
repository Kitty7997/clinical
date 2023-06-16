@include('frontend/header')

    <!-- <iframe class="common_header" src="../pages/header.html"></iframe> -->

    <section class="account_sec">
        <div class="container">
            <div class="account_top">
                <h2>Create Account</h2>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                    alteration in some form, by injected humour, or randomised words which don't look even slightly
                    believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't
                    anything embarrassing <a href="{{ url('/login') }}" class="login-here">Log in here</a></p>
            </div>

            <div class="form_hold">
                <div class="heading_text">
                    <h3>Account details</h3>
                </div>
             

                <form class="account_form" action="{{url('/postregister')}}" method="post">
                    @csrf
                    <div class="inner_name">
                        <label class="form_label" for="fname">First name:
                            <input type="text" id="fname" name="fname"></label>
							<span class="text-danger">
								@error('fname')
									{{$message}}
								@enderror
							</span>
                        <label class="form_label" for="lname">Last name:
                            <input type="text" id="lname" name="lname"></label>
							<span class="text-danger">
								@error('lname')
									{{$message}}
								@enderror
							</span>
                    </div>
                    <label class="form_label" for="phone">Mobile number
                        <input type="tel" id="phone" name="phone"></label>
							<span class="text-danger">
								@error('phone')
									{{$message}}
								@enderror
							</span>
                    <label class="form_label" for="email">Email address
                        <input type="email" id="email" name="email"></label>
						<span class="text-danger">
							@error('email')
								{{$message}}
							@enderror
						</span>
                    <div class="seprater"></div>
                    <div class="heading_text">
                        <h3>Create password</h3>
                    </div>
                    <div class="password_info">
                        <ul>
                            <li>At least 8 characters</li>
                            <li>5 or more unique characters</li>
                        </ul>
                    </div>
                    <label class="form_label" for="pwd">Password
                        <input class="password" type="password" id="pwd" name="password"></label>
						<span class="text-danger">
							@error('password')
								{{$message}}
							@enderror
						</span>
                    <label class="form_label" for="pwd">Confirm Password
                        <input class="password" type="password" id="cpwd" name="confirmpassword"></label>
						<span class="text-danger">
							@error('confirmpassword')
								{{$message}}
							@enderror
						</span>
                    <div class="seprater"></div>
                    <div class="checkbox_outer">
                        <div class="checkbox_hold">
                            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" required>
                            <label for="vehicle1"> I agree all the Terms and Privacy policy</label>
                        </div>
                        <div class="checkbox_hold">
                            <input type="checkbox" id="vehicle2" name="vehicle2" value="Car" required>
                            <label for="vehicle2"> Contrary to popular belief, Lorem Ipsum is not simply random text.
                                It
                                has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years
                                old</label>
                        </div>
                    </div>
                    <div class="continue_button">
                        <button class="button">Continue</button>
                    </div>
                    <!-- <input type="submit" value="Submit"> -->
                </form>

            </div>
        </div>
    </section>
</body>

</html>


<script type="text/javascript">
    $(document).ready(function() {
        $('a.test_step')
            .click(function(e) {
                $('a.test_step').removeClass("active");
                $(this).addClass("active");
            });
    });
</script>

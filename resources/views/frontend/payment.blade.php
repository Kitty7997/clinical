@include('frontend/header')


<!-- <iframe class="common_header" src="../pages/header.html"></iframe> -->

<section class="payment_sec">
    <div class="container_payment">
        <div class="payment_inner">
          @if($newTotal)
          <div class="payment_details">
            @foreach ($billData as $billingData)
                <div class="detail_step">
                    <div class="left_details">
                        <h4><svg class="green_tick" width="13" height="11" viewBox="0 0 13 11" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.7385 1.8468L4.60555 9.01551L1.03906 5.43116" stroke="#FBF9F8"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Account Details</h4>
                        <p>{{ $billingData->fname }} {{ $billingData->lname }}</p>
                        <p>{{ $billingData->number }}</p>
                        <p>{{ $billingData->email }}</p>
                    </div>
                    <div class="my-btn">
                        <a href="{{ url('/billedit') }}/{{ $billingData->id }}">
                            <div class="right_button_edit">
                                <button id="editBtn" type="button">Edit</button>
                            </div>
                        </a>
                        <a href="{{ url('/deletebill') }}/{{ $billingData->id }}">
                            <div class="right_button_edit">
                                <button class="button">Remove</button>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
            {{-- @foreach ($deliveryData as $data)
                <div class="detail_step">
                    <div class="left_details">
                        <h4><svg class="green_tick" width="13" height="11" viewBox="0 0 13 11" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.7385 1.8468L4.60555 9.01551L1.03906 5.43116" stroke="#FBF9F8"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>Delivery Address</h4>
                        <p>{{ $data->fname }} {{ $data->lname }}</p>
                        <p>{{ $data->phone }}</p>
                        <p>{{ $data->city }}</p>
                    </div>
                    <div class="my-btn">
                        <a href="{{ url('/edit') }}/{{ $data->id }}">
                            <div class="right_button_edit">
                                <button id="editBtnDelivery" class="button">Edit</button>
                            </div>
                        </a>
                        <a href="{{ url('/delete') }}/{{ $data->id }}">
                            <div class="right_button_edit">
                                <button class="button">Remove</button>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach --}}

            <div class="main_heading">
                <h2>Payment Details</h2>
                <p>Select billing address</p>
            </div>
            <div class="detail_step payment_options">
                <div class="left_details">
                    <input type="radio" id="shipping" name="address_option" value="same">
                    <label class="payment_select" for="text">Billing Address</label>
                    <p>save as it to shipping address</p>
                </div>
            </div>
            <p class="or_text">or</p>
            <div class="Address_button">
                <button id="addAddress" type="button">{{ $title }}</button>
            </div>
            <div id="newAddress">
                <form class="address_form" action="{{ $url }}" method="post">
                    @csrf
                    <p class="new_address_text">{{ $title }}</p>
                    <div class="inner_name">
                        <label class="form_label" for="fname">First name
                            <input type="text" id="fname" name="fname"
                                value="@if (isset($billDataNew)) {{ $billDataNew->fname }} @endif"></label>
                        <span class="text-danger">
                            @error('fname')
                                {{ $message }}
                            @enderror
                        </span>
                        <label class="form_label" for="lname">Last name *
                            <input type="text" id="lname" name="lname"
                                value="@if (isset($billDataNew)) {{ $billDataNew->lname }} @endif"></label>
                        <span class="text-danger">
                            @error('lname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="inner_name">
                        <label class="form_label" for="number">Mobile number *
                            <input type="number" id="number" name="number"
                                value="@if (isset($billDataNew)) {{ $billDataNew->number }} @endif"></label>
                        <span class="text-danger">
                            @error('number')
                                {{ $message }}
                            @enderror
                        </span>
                        <label class="form_label" for="email">Email address
                            <input type="email" id="email" name="email"
                                value="@if (isset($billDataNew)) {{ $billDataNew->email }} @endif"></label>
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="assesment_button">
                        <button id="" class="button">Save</button>
                        <button id="cancel" class="bg_brown" type="button">Cancel</button>
                    </div>
                </form>
            </div>

            <div class="seprater_cart"></div>
            <div class="main_heading">
                <p>Payment method</p>
            </div>

            <div id="payment1" class="payment_options">
                <div id="googlePay" class="options_step">
                    <input type="radio" id="shipping" name="fav_language" value="Google Pay">
                    <label class="payment_select" for="text">Google Pay</label>
                </div>
                <div class="pay_with">
                    <img src="../images/Apple_Pay.svg">
                </div>
            </div>
            <div class="assesment_button">
                <button id="Gpay" class="gpay-btn bg_brown" type="button">Proceed with Google Pay</button>
            </div>
            <div id="payment2" class="payment_options">
                <div id="applePay" class="options_step">
                    <input type="radio" id="shipping" name="fav_language" value="Apple Pay">
                    <label class="payment_select" for="text">Apple Pay</label>
                </div>
                <div class="pay_with">
                    <img src="../images/Apple_Pay.svg">
                </div>
            </div>
            <div class="assesment_button">
                <button id="Apple" class="gpay-btn bg_brown" type="button">Proceed with Apple Pay</button>
            </div>
            <div id="payment3" class="payment_options">
                <div id="payPal" class="options_step">
                    <input type="radio" id="shipping" checked="checked" name="fav_language" value="Paypal">
                    <label class="payment_select" for="text">Paypal</label>
                </div>
                <div class="pay_with">
                    <img src="../images/PayPal.png">
                </div>
            </div>
            {{-- <a href="{{url('/paymenthandle')}}" class="text-decorate"> --}}
            <div class="assesment_button">
                <button id="Paypal" class="gpay-btn bg_brown" type="button">Proceed with Paypal</button>
            </div>
         {{-- </a> --}}
            <div id="payment4" class="payment_options">
                <div id="zipPay" class="options_step">
                    <input type="radio" id="shipping" name="fav_language" value="Zip">
                    <label class="payment_select" for="text">Zip</label>
                    <p>Pay £56.00 in 4 months installments</p>
                </div>
                <div class="pay_with">
                    <img src="../images/Apple_Pay.svg">
                </div>
            </div>

            <div class="assesment_button">
                <button id="Zip" class="gpay-btn bg_brown" type="button">Proceed with Zip</button>
            </div>

          <a href="{{url('/stripe')}}" class="text-decorate">
            <div id="payment5" class="payment_options">
                <div id="creditPay" class="options_step">
                    <input type="radio" id="shipping" name="fav_language" value="Credit card">
                    <label class="payment_select" for="text">Credit card</label>
                </div>
                <div class="pay_with">
                    <img src="../images/Visa-logo.png">
                    <img class="master_card" src="../images/Mastercard-logo.png">
                    <img class="american_express" src="../images/american-express.png">
                </div>
            </div>
          </a>

            {{-- <form id="crediCard" class="crediCard_form">
                <label class="form_label" for="number">Card Number
                    <input placeholder="Enter card number" type="number" id="number"></label>
                <div class="inner_name">
                    <label class="form_label" for="lname">Expiry Date
                        <input type="date" id="start" name="trip-start" value="2025-12-26"
                            min="2025-01-01" max="2025-12-31">
                    </label>
                    <label class="form_label" for="number">CVC
                        <input placeholder="CVC" type="number" id="number"></label>
                </div>
            </form> --}}

            {{-- <div class="assesment_button">
                <button type="button">Continue</button>
            </div> --}}
        </div>
        @else
        <div class="order_box">
            <div class="order_img">
                <img src="../images/order-icon.png">
            </div>
            <h2 class="order_subHeading">You don't buy any product</h2>
            <p class="order_text_bottom">Please buy some products and enjoy the shopping journey </p>
            <a href="{{url('/')}}">
                <div class="get_started">
                    <button id="" class="bg_brown" type="button">Get Started</button>
                </div></a>
        </div>
        @endif
            <div class="payment_top">
                <div class="payment_right">
                    <p class="order">Your order</p>
                    @foreach ($item as $data)
                        <div class="hormone_test">
                            <div class="step_left">
                                <img src="{{ $data->image }}">
                            </div>

                            <div class="step_center">
                                <h3>{{ $data->head }}</h3>
                                <div class="price_dispaly">
                                    <h3>£{{ $data->totalPrice }}.00</h3>
                                    <h5>Quantity:{{ $data->quantity }}</h5>
                                </div>
                            </div>

                            <div class="step_right">
                                <a href="{{ url('/remove') }}/{{ $data->id }}">
                                    <img class="cross_white" src="../images/cross_white.svg">
                                </a>
                            </div>
                        </div>
                    @endforeach

                    <div class="discount_code">
                        <div class="order_receipt">
                            <p class="code_text">Discount code</p>
                            <p class="applied_msg">Discount applied!</p>
                        </div>
                        <div class="order_receipt">
                            <div class="code_input">
                                <input type="number" id="quantity" name="quantity">
                                <p>HERTILITYHEALTH</p>
                            </div>
                            <div class="code_button">
                                <input class="submit_button" value="Apply" type="submit">
                            </div>
                        </div>
                    </div>

                    <div class="receipt">
                        <div class="order_receipt">
                            <p>Item</p>
                            <p>{{ count($item) }}</p>
                        </div>
                        {{-- <div class="order_receipt">
						<p style="color: #fa4446;">Discount</p>
						<p style="color: #fa4446;">-£35</p>
					</div> --}}
                        <div class="order_receipt">
                            <p>Shipping Cart</p>
                            <p>Free</p>
                        </div>
                        <div class="order_receipt">
                            <h2>Total</h2>
                            <span>
                                <p style="font-size: 45px; font-weight: 500; text-align: right;">
                                    £{{ $newTotal }}.00</p>
                                <p style="font-size: font-size: 17px;"></p>
                            </span>
                        </div>
                    </div>
                    <p class="bottom_text">We get it, private healthcare isn't cheap.</p>
                </div>
                <div class="payment_bottom">
                    <p>Excellent <img src="../images/trustpilot_rating.svg"></p>
                </div>
            </div>
        </div>
    </div>
</section>
</body>

</html>


<script type="text/javascript">
    $('.payment_options').click(function() {
            $('.selected').removeClass('selected');
            $(this).addClass('selected').find('input').prop('checked', true)
        }),

        $('#payment1').click(function() {
            $("#Gpay").toggle();
            $("#Apple").hide();
            $("#Paypal").hide();
            $("#Zip").hide();
            $("#crediCard").hide();
            document.getElementById("googlePay").innerHTML = "Pay with Google Pay";
        }),
        $('#payment2').click(function() {
            $("#Apple").toggle();
            $("#Gpay").hide();
            $("#Paypal").hide();
            $("#Zip").hide();
            $("#crediCard").hide();
            document.getElementById("applePay").innerHTML = "Pay with Apple Pay";
        }),
        $('#payment3').click(function() {
            $("#Paypal").toggle();
            $("#Apple").hide();
            $("#Zip").hide();
            $("#Gpay").hide();
            $("#crediCard").hide();
            document.getElementById("payPal").innerHTML = "Pay with Paypal";
        }),
        $('#payment4').click(function() {
            $("#Zip").toggle();
            $("#Paypal").hide();
            $("#Apple").hide();
            $("#Gpay").hide();
            $("#crediCard").hide();
            document.getElementById("zipPay").innerHTML = "Pay with Zip";
        }),
        $('#payment5').click(function() {
            $("#crediCard").toggle();
            $("#Paypal").hide();
            $("#Apple").hide();
            $("#Gpay").hide();
            $("#Zip").hide();
            document.getElementById("creditPay").innerHTML = "Pay with Credit card";
        });

    // payment details toggle
    $("#addAddress").click(function() {
            $("#newAddress").toggle();
            $("#newAddress4").hide();
            $("#addAddress").hide();
        }),

        $("#cancel").click(function() {
            $("#newAddress").hide();
            $("#addAddress").show();
        });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('a.test_step')
            .click(function(e) {
                $('a.test_step')
                    .removeClass("active");
                $(this).addClass("active");
            });
    });
</script>

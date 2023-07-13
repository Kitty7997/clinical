@include('frontend/header')


<!-- <iframe class="common_header" src="../pages/header.html"></iframe> -->

@if ($errors->any())
    <div class="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<section class="payment_sec">
    <div class="container_payment">
        <div class="payment_inner" id="payment_flex" @if($totalAmount < 1) style="display: unset" @else style="display: flex" @endif>
           
            <div class="payment_details" id="payment_address" @if($totalAmount < 1) style="display: none" @else style="display: block" @endif>


                <div id="main_payment">
                    <div class="main_heading">
                        <h2>Payment Details</h2>
                        <p>Select billing address</p>
                    </div>
                    <div class="detail_step payment_options">
                        <div class="left_details">
                            <input type="radio" id="shipping" name="address_option" value="same" onclick="showData()">
                            <label class="payment_select" for="text">Billing Address</label>
                            <p>save as it to shipping address</p>
                        </div>
                    </div>
                   {{-- <div id="billing_details">
                    <div class="detail_step">
                        <div class="left_details">
                            <h4><svg class="green_tick" width="13" height="11" viewBox="0 0 13 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.7385 1.8468L4.60555 9.01551L1.03906 5.43116" stroke="#FBF9F8"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg> Billing Address</h4>
                            <p>{{ $deliveryData[0]->fname }}</p>
                            <p>{{ $deliveryData[0]->phone }}</p>
                            <p>{{ $deliveryData[0]->city }}</p>
                        </div>
                       </div>
                   </div> --}}

                   @if (!$billData)
                    @else
                        <div class="detail_step" id="delivery_id{{ $billData->id }}">
                            <div class="left_details">
                                <h4><svg class="green_tick" width="13" height="11" viewBox="0 0 13 11"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.7385 1.8468L4.60555 9.01551L1.03906 5.43116" stroke="#FBF9F8"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> Billing addresss</h4>
                                <p id="bill_fname">{{ $billData->fname }} {{ $billData->lname }}</p>
                                <p id="bill_number">{{ $billData->number }}</p>
                                <p id="bill_email">{{ $billData->email }}</p>
                            </div>
                            <div class="my-btn">
                                {{-- <a href="{{ url('/billedit') }}/{{ $billData->id }}">
                                    <div class="right_button_edit">
                                        <button id="editBtn" type="button">Edit</button>
                                    </div>
                                </a> --}}
                                <a onclick="deleteItem('{{$billData->id}}')" >
                                    <div class="right_button_edit">
                                        <button class="button">Remove</button>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                    <p class="or_text">or</p>
                    <div class="Address_button">
                        <button id="addAddress" type="button">{{ $title }}</button>
                    </div>
                    <div id="newAddress">
                        <div class="address_form" id="bill">
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
                                <button class="button" onclick="billAddress()">Save</button>
                                <button id="cancel" class="bg_brown" type="button">Cancel</button>
                            </div>
                        </div>
                    </div>

                    {{-- @if (!$billData) --}}
                    <div id="bill_add" @if($billData) style="display: none" @else style="display: block" @endif>
                        <div class="order_box mt-5">
                            <div class="order_img">
                                <img src="../images/order-icon.png">
                            </div>
                            <h2 class="order_subHeading">Please enter billing address first to continue</h2>
                            <p class="order_text_bottom">Enjoy the shopping journey with us!</p>
                            <a href="{{ url('/payment') }}">
                                <div class="get_started">
                                    <button id="" class="bg_brown" type="button">Enter Delivery
                                        Address</button>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- @else --}}
                        <div id="payment_method" @if($billData) style="display: block" @else style="display: none" @endif>
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
                            <button id="Gpay" class="gpay-btn bg_brown" type="button">Proceed with Google
                                Pay</button>
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
                            <button id="Apple" class="gpay-btn bg_brown" type="button">Proceed with Apple
                                Pay</button>
                        </div>
                        <div id="payment3" class="payment_options">
                            <div id="payPal" class="options_step">
                                <input type="radio" id="shipping" checked="checked" name="fav_language"
                                    value="Paypal">
                                <label class="payment_select" for="text">Paypal</label>
                            </div>
                            <div class="pay_with">
                                <img src="../images/PayPal.png">
                            </div>
                        </div>
                        {{-- <a href="{{url('/paymenthandle')}}" class="text-decorate"> --}}
                        <div class="assesment_button">
                            <button id="Paypal" class="gpay-btn bg_brown" type="button">Proceed with
                                Paypal</button>
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
                            <button id="Zip" class="gpay-btn bg_brown" type="button">Proceed with
                                Zip</button>
                        </div>


                        <a href="{{ url('/stripe') }}" class="text-decorate">
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
                        </div>
                    {{-- @endif --}}
                </div>
        
        </div>

            <div id="payment_box"
                @if ($totalAmount < 1) style="display: block" @else style="display: none" @endif>
                <div class="order_box">
                    <div class="order_img">
                        <img src="../images/order-icon.png">
                    </div>
                    <h2 class="order_subHeading">You have not buy any product yet</h2>
                    <p class="order_text_bottom">Please buy some products and enjoy the shopping journey </p>
                    <a href="{{ url('/') }}">
                        <div class="get_started">
                            <button id="" class="bg_brown" type="button">Get Started</button>
                        </div>
                    </a>
                </div>
            </div>

            <div id="delivery_box"
            @if ($totalAmount < 1) style="display: none" @else style="display: block" @endif>
            <div class="payment_top">
                <div class="payment_right">
                    <p class="order">Your order</p>
                    @foreach ($cart as $data)
                        <div class="hormone_test" id="delete{{ $data->productId }}">
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
                                <a onclick="removeItem('{{ $data->productId }}')">
                                    <img class="cross_white" src="../images/cross_white.svg">
                                </a>
                            </div>
                        </div>
                    @endforeach

                    <div class="discount_code">
                        <div class="order_receipt">
                            <p class="code_text">Discount code</p>
                            {{-- @if (Session::has('success'))
                                <div class="my_alert">
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                            @endif
                            @if (Session::has('error'))
                                <div class="my_error_alert">
                                    <p>{{ Session::get('error') }}</p>
                                </div>
                            @endif --}}
                        </div>
                        {{-- <form action="{{$myUrl}}" method="post">  
                        @csrf --}}
                        <div class="order_receipt">
                            <div class="code_input">
                                <input type="text" id="discount" name="code"
                                    value="{{ $cart[0]->voucher }}">

                            </div>
                            <div class="code_button">
                                <input class="submit_button" name="action" id="btn_value" type="submit"
                                    @if (!$cart[0]->voucher) value="Apply" @else value="Remove" @endif
                                    onclick="applyCoupon()">
                            </div>
                        </div>
                        {{-- </form> --}}
                    </div>

                    <div class="receipt">
                        <div class="order_receipt">
                            <p>Item</p>
                            <p id="paymentcartCount">{{ $itemCount }}</p>
                        </div>
                        <div id="my_voucher"   @if ($cart[0]->voucher) style="display:block" @else style="display:none" @endif>
                            <div class="order_receipt">
                                <p style="color: #fa4446;">Discount</p>
                                <p id="my_discount" style="color: #fa4446;">-£{{ $couponDiscount }}</p>
                            </div>
                        </div>
                        {{-- @else
                    @endif --}}
                        <div class="order_receipt">
                            <p>Shipping Cart</p>
                            <p>Free</p>
                        </div>
                        <div class="order_receipt">
                            <h2>Total</h2>
                            <span>
                                <p style="font-size: 45px; font-weight: 500; text-align: right;" id="amount">

                                    £{{ $totalAmount }}.00

                                </p>
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
        </div>
</section>

<input type="hidden" id="myUrl" value="{{$myUrl}}">

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

    $("#coupon-button").click(function() {
        $(this).html("Remove");
    })
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

    function removeItem(id) {
        var url = `{{ url('/remove/') }}/${id}`;

        var csrfToken = '{{ csrf_token() }}';
        var data = {
            id: id,
            _token: csrfToken
        };
        $.ajax({
            type: 'GET',
            url: url,
            data: data,
            dataType: 'json',
            success: function(result) {

                if (result.count < 1) {
                    $('.payment_details').css('flex', 'auto');
                    $('#cartCount').removeClass('cart_style');
                    $('#cartCount').empty();
                    $('#paymentcartCount').text(result.count);
                    $('#payment_box').show();
                    $('#delivery_box').hide();
                    $('#discount').val('');
                    $('#payment_address').hide();
                    $('#payment_unset').show();
                    $('#payment_flex').css('display', 'unset');
                } else {
                    $('#cartCount').text(result.count);
                    $('#paymentcartCount').text(result.count);
                    $('#payment_box').hide();
                    $('#delivery_box').show();
                    $('#payment_address').show();
                    $('payment_unset').hide();
                    $('#payment_flex').css('display', 'flex');

                }

                if (result.total < 100) {
                    $('#my_voucher').hide();
                    $('#btn_value').val('Apply');
                    $('#discount').val('');
                }

                $('#delete' + id).remove();
                $('#amount').text('£' + result.total + '.00');
            }
        });
    }

    function applyCoupon() {
        var csrfToken = '{{ csrf_token() }}';
        var url = $('#myUrl').val();
        var code = $('#discount').val();
        var action = $('#btn_value').val();
        var data = {
            _token: csrfToken,
            "code": code,
            'action': action,
        };

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(result) {
                // console.log(result.total);
                $('#btn_value').val(result.btnValue);
                $('#amount').text('£' + result.total + '.00');
                $('#discount').val(result.inputData);
                $('#form').text(result.myUrl);
                $('#my_discount').text('-£' + result.discount);
                if (result.discount > 1) {
                    $('#my_voucher').show();
                } else {
                    $('#my_voucher').hide();
                }
                $('#myUrl').val(result.myUrl);
            }
        });
    }

    function deleteItem(id) {
        var url = `{{ url('/deletebill/') }}/${id}`;

        var csrfToken = '{{ csrf_token() }}';
        var data = {
            id: id,
            _token: csrfToken
        };
        $.ajax({
            type: 'GET',
            url: url,
            data: data,
            success: function(result) {
            
                // if(result.bill){
                //     $('#payment_method').show();
                //     $('#bill_add').hide();
                // }else{
                //     $('#payment_method').hide();
                //     $('#bill_add').show();
                // }

                $('#delivery_id' + id).remove();
            }
        });
    }


    function billAddress(){  
        var csrfToken = '{{ csrf_token() }}';
        var url = "{{url('/billadd')}}";
        var data = {
            '_token' : csrfToken,
        }
        $.ajax({
            type : 'POST',
            url : url,
            data : data,
            dataType : 'json',
            success:function(result){
                console.log(result.bill)
                $('#fname').val(result.bill.fname);
                $('#lname').val(result.bill.lname);
                $('#number').val(result.bill.number);
                $('#email').val(result.bill.email);
            }
        })
    }

</script>

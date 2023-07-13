@include('frontend/header')

<!-- <iframe class="common_header" src="../pages/header.html"></iframe> -->


<section class="delivery_sec">
    <div class="container_payment">
        <div class="payment_inner">
            <div class="payment_details">


                @if (!$deliveryData)
                @else
                    <div class="detail_step" id="delivery_id{{ $deliveryData->id }}">
                        <div class="left_details">
                            <h4><svg class="green_tick" width="13" height="11" viewBox="0 0 13 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.7385 1.8468L4.60555 9.01551L1.03906 5.43116" stroke="#FBF9F8"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg> Delivery Address</h4>
                                <p>{{ $deliveryData->fname }}</p>
                                <p>{{ $deliveryData->phone }}</p>
                                <p>{{ $deliveryData->city }}</p>
                        </div>
                        <div class="my-btn">
                            <a href="{{ url('/edit') }}/{{ $deliveryData->id }}">
                                <div class="right_button_edit">
                                    <button id="editBtnDelivery" class="button">Edit</button>
                                </div>
                            </a>
                            <a onclick="deleteItem('{{ $deliveryData->id }}')">
                                <div class="right_button_edit">
                                    <button class="button">Remove</button>
                                </div>
                            </a>
                            <div class="New_address_form">
                                <form class="address_form" action="{{ $url }}" method="post">
                                    @csrf
                                    <div class="my_form_style">
                                        <p class="new_address_text">Add new address</p>
                                        <div class="inner_name">
                                            <label class="form_label" for="fname">First name *
                                                <input type="text" id="fname" name="fname"
                                                    value="{{ $deliveryData->fname }}"></label>
                                            <span class="text-danger">
                                                @error('fname')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            <label class="form_label" for="lname">Last name *
                                                <input type="text" id="lname" name="lname"
                                                    value="{{ $deliveryData->lname }}"></label>
                                            <span class="text-danger">
                                                @error('lname')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="inner_name">
                                            <label class="form_label" for="number">Mobile number *
                                                <input type="number" id="number" name="phone"
                                                    value="{{ $deliveryData->phone }}"></label>
                                            <span class="text-danger">
                                                @error('phone')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            <label class="form_label" for="lname">Street address *
                                                <input type="text" id="address" name="street"
                                                    value="{{ $deliveryData->street }}"></label>
                                            <span class="text-danger">
                                                @error('street')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="inner_name">
                                            <label class="form_label" for="number">Flat / Apartment No. *
                                                <input type="text" id="text" name="flat"
                                                    value="{{ $deliveryData->flat }}"></label>
                                            <span class="text-danger">
                                                @error('flat')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            <label class="form_label" for="lname">Town / City *
                                                <input type="text" id="address" name="city"
                                                    value="{{ $deliveryData->city }}"></label>
                                            <span class="text-danger">
                                                @error('city')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="inner_name">
                                            <label class="form_label" for="lname">Country / Region *
                                                <input type="text" id="address" name="country"
                                                    value="{{ $deliveryData->country }}"></label>
                                            <span class="text-danger">
                                                @error('country')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            <label class="form_label" for="number">Postcode *
                                                <input type="number" id="number" name="postcode"
                                                    value="{{ $deliveryData->postcode }}"></label>
                                            <span class="text-danger">
                                                @error('postcode')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ url('/continue') }}/{{ $deliveryData->id }}">
                                        <div class="right_button_edit my_continue_btn">
                                            <button class="button">Continue with this address</button>
                                        </div>
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif



                <div class="main_heading">
                    <h2>Delivery Address</h2>
                </div>

                <div class="New_address_form">
                    <form class="address_form" action="{{ $url }}" method="post">
                        @csrf
                        <p class="new_address_text">Add new address</p>
                        <div class="inner_name">
                            <label class="form_label" for="fname">First name *
                                <input type="text" id="fname" name="fname"
                                    value="@if (isset($editData)) {{ $editData->fname }} @endif"></label>
                            <span class="text-danger">
                                @error('fname')
                                    {{ $message }}
                                @enderror
                            </span>
                            <label class="form_label" for="lname">Last name *
                                <input type="text" id="lname" name="lname"
                                    value="@if (isset($editData)) {{ $editData->lname }} @endif"></label>
                            <span class="text-danger">
                                @error('lname')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="inner_name">
                            <label class="form_label" for="number">Mobile number *
                                <input type="number" id="number" name="phone"
                                    value="@if (isset($editData)) {{ $editData->phone }} @endif"></label>
                            <span class="text-danger">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </span>
                            <label class="form_label" for="lname">Street address *
                                <input type="text" id="address" name="street"
                                    value="@if (isset($editData)) {{ $editData->street }} @endif"></label>
                            <span class="text-danger">
                                @error('street')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="inner_name">
                            <label class="form_label" for="number">Flat / Apartment No. *
                                <input type="text" id="text" name="flat"
                                    value="@if (isset($editData)) {{ $editData->flat }} @endif"></label>
                            <span class="text-danger">
                                @error('flat')
                                    {{ $message }}
                                @enderror
                            </span>
                            <label class="form_label" for="lname">Town / City *
                                <input type="text" id="address" name="city"
                                    value="@if (isset($editData)) {{ $editData->city }} @endif"></label>
                            <span class="text-danger">
                                @error('city')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="inner_name">
                            <label class="form_label" for="lname">Country / Region *
                                <input type="text" id="address" name="country"
                                    value="@if (isset($editData)) {{ $editData->country }} @endif"></label>
                            <span class="text-danger">
                                @error('country')
                                    {{ $message }}
                                @enderror
                            </span>
                            <label class="form_label" for="number">Postcode *
                                <input type="number" id="number" name="postcode"
                                    value="@if (isset($editData)) {{ $editData->postcode }} @endif"></label>
                            <span class="text-danger">
                                @error('postcode')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="assesment_button">
                            <button class="button">Continue</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- @if ($item->isEmpty()) --}}
            <div id="payment_box"
                @if ($itemCount < 1) style="display: block" @else style="display: none" @endif>
                <div class="basket_hold">
                    <div class="basket_items">
                        <img src="../images/cart.svg">
                        <p>Matching to show here<br>right now</p>
                    </div>
                    <div class="assesment_button">
                        <button type="button">Start health Assesment</button>
                    </div>
                </div>
            </div>
            {{-- @else --}}
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
                            <div id="my_voucher" @if (!$cart[0]->voucher) style="display:none" @else style="display:block" @endif>
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
            {{-- @endif --}}
        </div>
    </div>

</section>
<input type="hidden" id="myUrl" value="{{$myUrl}}">
</body>

</html>


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

<script type="text/javascript">
    // delivery details toggle
    $("#editBtnDelivery").click(function() {
            $("#deliveryAddress").toggle();
        }),
        $("#cancelNew").click(function() {
            $("#deliveryAddress").hide();
            // $("#addAddress").show();
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
        var url = `{{ url('/delete/') }}/${id}`;

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
                $('#delivery_id' + id).remove();
            }
        });
    }
</script>

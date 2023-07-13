@include('frontend.header')


<!-- <iframe class="common_header" src="../pages/header.html"></iframe> -->
<section class="cart-section">
    <div class="container">
        <div class="heading_text">
            <h2>In your Cart</h2>

            <p id="cartCount2">
                {{ $itemCount }}
                item in your basket
            </p>
        </div>



        {{-- @if (!$itemCount) --}}
        <div class="basket_hold" id="cart_basket"
            @if ($itemCount < 1) style="display: block" @else style="display: none" @endif>
            <div class="basket_items">
                <img src="../images/cart.svg">
                <p>Matching to show here<br>right now</p>
            </div>
            <div class="assesment_button">
                <button type="button">Start health Assesment</button>
            </div>
        </div>

        {{-- @else --}}

        <div id="cart_items">
            @foreach ($cart as $value)
                <div class="cart_item nurse_visit" id="delete{{ $value->productId }}">
                    <div class="nurse_visit_inner">
                        <div class="left_img">
                            <img src="{{ $value->image }}">
                        </div>
                        <div class="center_text">
                            <h3>{{ $value->head }}</h3>
                            <h3 id="itemPrice">£{{ $value->totalPrice }}</h3>
                            <h3>Quantity: <span id="itemQuantity">{{ $value->quantity }}</span></h3>
                        </div>
                    </div>
                    <a onclick="removeItem('{{ $value->productId }}')">
                        <img class="cross_icon" src="../images/cross.svg">
                    </a>
                </div>
            @endforeach
        </div>
        


        <div id="my_cart_total"
            @if ($itemCount > 0) style="display: block" @else style="display: none" @endif>
            <div class="order_total">
                <div class="order_receipt">
                    <p>Item</p>
                    <p id="cartCount3">{{ $itemCount }}</p>
                </div>

                <div class="order_receipt">
                    <p>Shipping Cart</p>
                    <p>Free</p>
                </div>

                <div class="order_receipt">
                    <h2>Total</h2>
                    <span>
                        <p style="font-size: 42px; padding-top: 10px; text-align: right;" id="amount">
                            £{{ $overallTotal }}.00</p>

                        <p style="font-size: font-size: 17px;">We get it, private healthcare isn't cheap.</p>
                    </span>
                </div>
            </div>

            <div class="button-inner">
                <div class="checkout_button assesment_button">
                    <a href="{{ url('/delivery') }}"><button type="button">Go to Checkout</button></a>
                </div>
            </div>
        </div>

        {{-- @endif --}}
        <div class="seprater_cart"></div>
        <div class="best_seller">
            <h3>Hertility best-sellers</h3>
        </div>
        @foreach ($clinicaldata as $data)
            <div class="nurse_visit">
                <div class="nurse_visit_inner">
                    <div class="left_img">
                        <img src="{{ $data->image }}">
                    </div>
                    <div class="center_text">
                        <h3>{{ $data->head }}</h3>
                        <h3>£{{ $data->price }}.00</h3>
                        <p>{{ $data->para }}</p>
                        <a href="#">More info</a>
                    </div>
                    <div class="right_button">
                        <button class="button" onclick="addTocart('{{ $data->id }}')">Add</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>


<script>
    function addTocart(id) {
        var csrfToken = '{{ csrf_token() }}';
        var url = '/add_to_cart';
        
        var data = {
            id: id,
            _token: csrfToken
        };

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'JSON',
            success: function(result) {
                const items = result.cart;
                console.log(items);
                $('#cartCount').addClass('cart_style');
                $('#cartCount').text(result.count);
                $('#cartCount2').text(result.count + ' item in your basket ');
                $('#cart_basket').hide();
                $('#my_cart_total').show();
                $('#itemPrice').text('£' + result.total);
                $('#cart_items').empty();
                items.forEach((item) => {
                    const cartItemHTML = `
                    <div class="cart_item nurse_visit" id="delete${item.productId}">
                        <div class="nurse_visit_inner">
                        <div class="left_img">
                            <img src="${item.image}">
                        </div>
                        <div class="center_text">
                            <h3>${item.head}</h3>
                            <h3>£${item.totalPrice}</h3>
                            <h3>Quantity: ${item.quantity}</h3>
                        </div>
                        </div>
                        <a onclick="removeItem('${item.productId}')"><img class="cross_icon" src="../images/cross.svg"></a>
                    </div>
                    `;

                    $('#cart_items').append(cartItemHTML);
                });



                $('#my_cart_total').html(`
                    <div class="order_total">
                    <div class="order_receipt">
                        <p>Item</p>
                        <p id="cartCount3">${result.count}</p>
                    </div>
                    <div class="order_receipt">
                        <p>Shipping Cart</p>
                        <p>Free</p>
                    </div>
                    <div class="order_receipt">
                        <h2>Total</h2>
                        <span>
                        <p style="font-size: 42px; padding-top: 10px; text-align: right;" id="amount">
                            £${result.total}.00</p>
                        <p style="font-size: font-size: 17px;">We get it, private healthcare isn't cheap.</p>
                        </span>
                    </div>
                    </div>
                    <div class="button-inner">
                    <div class="checkout_button assesment_button">
                        <a href="{{ url('/delivery') }}"><button type="button">Go to Checkout</button></a>
                    </div>
                    </div>
                `);
            }
        });
    }



    function removeItem(id) {
        var url = `{{ url('/remove') }}/${id}`;
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
                console.log(result.count);
                if (result.count < 1) {
                    $('#cartCount').removeClass('cart_style');
                    $('#cartCount').empty();
                    $('#cartCount2').text(result.count + ' item in your basket ');
                    $('#cartCount3').text(result.count);
                    $('#cart_basket').show();
                    $('#my_cart_total').hide();
                } else {
                    $('#cartCount').text(result.count);
                    $('#cartCount2').text(result.count + ' item in your basket ');
                    $('#cartCount3').text(result.count);
                    $('#cart_basket').hide();
                    $('#my_cart_total').show();
                }
                $('#delete' + id).remove();
                $('#amount').text('£' + result.total + '.00');
            }
        });

    }
</script>

</body>

</html>

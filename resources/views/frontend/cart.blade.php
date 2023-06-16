@include('frontend.header')


<!-- <iframe class="common_header" src="../pages/header.html"></iframe> -->
<section class="cart-section">
    <div class="container">
        <div class="heading_text">
            <h2>In your Cart</h2>
            <p>{{ count($item) }} item in your basket</p>
        </div>

        @if ($item->isEmpty())
            <div class="basket_hold">
                <div class="basket_items">
                    <img src="../images/cart.svg">
                    <p>Matching to show here<br>right now</p>
                </div>
                <div class="assesment_button">
                    <button type="button">Start health Assesment</button>
                </div>
            </div>
        @else
            @foreach ($item as $data)
                <div class="cart_item nurse_visit">
                    <div class="nurse_visit_inner">
                        <div class="left_img">
                            <img src="{{ $data->image }}">
                        </div>
                        <div class="center_text">
                            <h3>{{ $data->head }}</h3>
                            <h3>£{{ $data->totalPrice }}</h3>
                            <h3>Quantity: {{ $data->quantity }}</h3>
                        </div>
                    </div>
                    <a href="{{ url('/remove') }}/{{ $data->id }}"><img class="cross_icon"
                            src="../images/cross.svg"></a>
                </div>
            @endforeach


            <div class="order_total">
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
                        <p style="font-size: 42px; padding-top: 10px; text-align: right;">£{{ $newTotal }}.00</p>
                        <p style="font-size: font-size: 17px;">We get it, private healthcare isn't cheap.</p>
                    </span>
                </div>
            </div>

            <div class="button-inner">
                <div class="checkout_button assesment_button">
                    <a href="{{ url('/delivery') }}"><button type="button">Go to Checkout</button></a>
                </div>
            </div>
        @endif
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
                        <form action="{{ url('/add_to_cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $data->id }}">
                            <button class="button">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>


</body>

</html>

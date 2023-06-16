@include('frontend/header')

<!-- <iframe class="common_header" src="../pages/header.html"></iframe> -->

<section class="yourTest_sec">
	<div class="container_payment">
		<div class="your_test_inner">
			<div class="advisor_top">
				<div class="advisor_img">
				    <img src="../images/advisor.png">
				</div>
				<div class="greater_experience">
				<h3>Speak to an Advisor for greater Experience</h3>
				<p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit</p>
			    </div>
				<div class="advisor_bottom">
					<div class="bottom-step">
						<div class="icon_hold">
							<img src="../images/personalized.png">
						</div>
						<div class="step_text">
							<p>Personalized<br>advice</p>
						</div>
					</div>

					<div class="bottom-step">
						<div class="icon_hold">
							<img src="../images/having-time.png">
						</div>
						<div class="step_text">
							<p>Have time to<br>ask question</p>
						</div>
					</div>

					<div class="bottom-step">
						<div class="icon_hold">
							<img src="../images/register.png">
						</div>
						<div class="step_text">
							<p>Our Advisor are<br>Registered Nurses<br>based in the UK</p>
						</div>
					</div>
				</div>
				<div class="user_review">
					<img src="../images/trustpilot_rating.svg">
					<p class="review_text">"On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment</p>
					<p class="user_name">Amanda</p>
				</div>
				<div class="nurse_visit">
			    <div class="nurse_visit_inner">
				<div class="left_img">
					<img src="../images/health-care-station.jpg">
				</div>
				<div class="center_text">
					<h3>{{$clinicaldata[1]->head}}</h3>
					<h3>£{{$clinicaldata[1]->price}}.00</h3>
				</div>
				<div class="right_button">
					<form action="{{url('/add_to_cart')}}" method="post">
					@csrf
						<input type="hidden" name="product_id" value="{{$clinicaldata[1]->id}}">
						<button class="button">Add</button>
					</form>
				</div>
			</div>
		</div>
		<div class="clinicial_services_bottom">
			<a href="{{url('/cart')}}"><button type="button">Continue with Doctor-written report only</button></a>
		</div>
			</div>
			<div class="payment_top">
			@if($item->isEmpty())
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
				<div class="payment_right">
					<p class="order">Your order</p>
					@foreach($item as $data)
					<div class="hormone_test">
						<div class="step_left">
							<img src="{{$data->image}}">
						</div>

						<div class="step_center">
							<h3>{{$data->head}}</h3>
							<div class="price_dispaly">
							<h3>£{{$data->totalPrice}}.00</h3>
							<h5>Quantity:{{$data->quantity}}</h5>
							</div>
						</div>

						<div class="step_right">
							<a href="{{url('/remove')}}/{{$data->id}}">
							<img class="cross_white" src="../images/cross_white.svg">
							</a>
						</div>
					</div>
					@endforeach
				<div class="receipt">	
					<div class="order_receipt">
						<p>Item</p>
						<p>{{count($item)}}</p>
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
						<span><p style="font-size: 45px; font-weight: 500; padding-top: 10px; text-align: right;">£{{$newTotal}}.00</p><p style="font-size: font-size: 17px;"></p></span>
					</div>
				</div>
					<p class="bottom_text">We get it, private healthcare isn't cheap.</p>
				</div>
				<div class="payment_bottom">
					<p>Excellent <img src="../images/trustpilot_rating.svg"></p>
				</div>
				@endif
		    </div>
		</div>
	</div>
</section>
</body>
</html>


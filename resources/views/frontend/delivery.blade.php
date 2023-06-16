@include('frontend/header')

<!-- <iframe class="common_header" src="../pages/header.html"></iframe> -->

<section class="delivery_sec">
	<div class="container_payment">
		<div class="payment_inner">
			<div class="payment_details">
				
				@foreach($deliveryData as $data)
				
				<div class="detail_step">
					<div class="left_details">
						<h4><svg class="green_tick" width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11.7385 1.8468L4.60555 9.01551L1.03906 5.43116" stroke="#FBF9F8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
						</svg> Delivery Address</h4>
						<p>{{$data->fname}}</p>
						<p>{{$data->phone}}</p>
						<p>{{$data->city}}</p>
					</div>
					<div class="my-btn">
						<a href="{{url('/edit')}}/{{$data->id}}">
							<div class="right_button_edit">
								<button id="editBtnDelivery" class="button">Edit</button>
							</div>
						</a>
						<a href="{{url('/delete')}}/{{$data->id}}">
							<div class="right_button_edit">
								<button class="button">Remove</button>
							</div>
						</a>
						<a href="{{url('/continue')}}/{{$data->id}}">
							<div class="right_button_edit my_continue_btn">
								<button class="button">Continue with this address</button>
							</div>
						</a>
					</div>
				</div>
				
				@endforeach
	

				
				<div class="main_heading">
					<h2>Delivery Address</h2>
				</div>

				<div class="New_address_form">
				<form class="address_form" action="{{$url}}" method="post">
					@csrf
					<p class="new_address_text">Add new address</p>
					<div class="inner_name">
					  <label class="form_label" for="fname">First name *
					  <input type="text" id="fname" name="fname" value="@if(isset($editData)){{$editData->fname}}@endif"></label>
					  <span class="text-danger">
						@error('fname')
							{{$message}}
						@enderror
					  </span>
					  <label class="form_label" for="lname">Last name *
					  <input type="text" id="lname" name="lname" value="@if(isset($editData)){{$editData->lname}}@endif"></label>
					  <span class="text-danger">
						@error('lname')
							{{$message}}
						@enderror
					  </span>
					</div>
					<div class="inner_name">
					  <label class="form_label" for="number">Mobile number *
					  <input type="number" id="number" name="phone" value="@if(isset($editData)){{$editData->phone}}@endif"></label>
					  <span class="text-danger">
						@error('phone')
							{{$message}}
						@enderror
					  </span>
					  <label class="form_label" for="lname">Street address *
					  <input type="text" id="address" name="street" value="@if(isset($editData)){{$editData->street}}@endif"></label>
					  <span class="text-danger">
						@error('street')
							{{$message}}
						@enderror
					  </span>
					</div>
					<div class="inner_name">
					  <label class="form_label" for="number">Flat / Apartment No. *
					  <input type="text" id="text" name="flat" value="@if(isset($editData)){{$editData->flat}}@endif"></label>
					  <span class="text-danger">
						@error('flat')
							{{$message}}
						@enderror
					  </span>
					  <label class="form_label" for="lname">Town / City *
					  <input type="text" id="address" name="city" value="@if(isset($editData)){{$editData->city}}@endif"></label>
					  <span class="text-danger">
						@error('city')
							{{$message}}
						@enderror
					  </span>
					</div>
					<div class="inner_name">
					  <label class="form_label" for="lname">Country / Region *
					  <input type="text" id="address" name="country" value="@if(isset($editData)){{$editData->country}}@endif"></label>
					  <span class="text-danger">
						@error('country')
							{{$message}}
						@enderror
					  </span>
					  <label class="form_label" for="number">Postcode *
					  <input type="number" id="number" name="postcode" value="@if(isset($editData)){{$editData->postcode}}@endif"></label>
					  <span class="text-danger">
						@error('postcode')
							{{$message}}
						@enderror
					  </span>
					</div>
					{{-- <div class="checkbox_outer">
					    <a class="find_address" href="#">Find your address</a>
				    <div class="checkbox_hold">
				     <input type="checkbox" id="address1" name="address1" value="billing address">
						<label for="address1">Also save as billing address</label>
				    </div>
				    <div class="checkbox_hold">
					  <input type="checkbox" id="address2" name="address2" value="Save address">
					    <label for="address2"> Save address for future updates</label>
				  </div>
				  </div> --}}
				  <div class="assesment_button">
					  <button class="button">Continue</button>
				  </div>
				</form>
			</div>
			</div>

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
			<div class="payment_top">
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
						<p>1</p>
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
						<span><p style="font-size: 45px; font-weight: 500; text-align: right;">£{{$newTotal}}.00</p><p style="font-size: font-size: 17px;"></p></span>
					</div>
				</div>
					<p class="bottom_text">We get it, private healthcare isn't cheap.</p>
				</div>
				<div class="payment_bottom">
					<p>Excellent <img src="../images/trustpilot_rating.svg"></p>
				</div>
		    </div>
			@endif
		</div>
	</div>
	
</section>

</body>
</html>


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

<script type="text/javascript">

  // delivery details toggle
  $("#editBtnDelivery").click(function () {
    $("#deliveryAddress").toggle();
  }),
  $("#cancelNew").click(function () {
     $("#deliveryAddress").hide();
     // $("#addAddress").show();
  });
</script>


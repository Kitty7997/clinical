@include('frontend/header')
@if (Session::has('success'))
                        <div class="alert-success text-center">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
	<section class="order_sec">
		<div class="container_fluid">
			<div class="top_heading">
				<h1>Yours Orders</h1>
			</div>
			@if(!$item->isEmpty())
			@foreach ($item as $data)
			<div class="cart_item nurse_visit">
				<div class="nurse_visit_inner">
					<div class="left_img">
						<img src="{{ $data->image }}">
					</div>
					<div class="center_text">
						<h3>{{ $data->head }}</h3>
						{{-- <h3>Quantity: {{ $data->quantity }}</h3> --}}
					</div>
				</div>
				{{-- <a href="{{ url('/remove') }}/{{ $data->id }}"><img class="cross_icon"
						src="../images/cross.svg"></a> --}}
			</div>
		@endforeach
		@else
			<div class="order_box">
				<div class="order_img">
					<img src="../images/order-icon.png">
				</div>
				<h2 class="order_subHeading">You don't have any order</h2>
				<p class="order_text_bottom">On the other hand, we denounce with righteous indignation and dislike men<br> who are so beguiled and demoralized by the charms of pleasure of the moment</p>
				<a href="{{url('/')}}">
					<div class="get_started">
						<button id="" class="bg_brown" type="button">Get Started</button>
					</div></a>
			</div>
			@endif
		</div>
	</section>

</body>
</html>
@include('frontend.header')

<!-- <iframe class="common_header" src="../pages/header.html"></iframe> -->

<section class="clinicial-services">
	<div class="container">
		<div class="top-header">
			<h3>Clinicial Services</h3>
		</div>

		@foreach($clinicaldata as $data)
		<div class="nurse_visit">
			<div class="nurse_visit_inner">
				<div class="left_img">
					<img src="{{$data->image}}">
				</div>
				<div class="center_text">
					<h3>{{$data->head}}</h3>
					<h3>£{{$data->price}}</h3>
					<p>{{$data->para}}</p>
					<a href="#">More info</a>
				</div>
				<div class="right_button">
					<form action="{{url('/add_to_cart')}}" method="post">
						@csrf
					<input type="hidden" name="product_id" value="{{$data->id}}">
					<button class="button">Add</button>
					</form>
					<!-- <a href="{{url('/add_to_cart')}}" name="product_id" value="{{$data->id}}">
					<button type="button">Add</button>
					</a> -->
				</div>
			</div>
		</div>
		@endforeach

		<div class="clinicial_services_bottom">
			<button type="button">Continue with Hormone & Fertility Test only</button>
		</div>

	</div>
</section>
</body>
</html>
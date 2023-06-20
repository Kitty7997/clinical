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
			@if($order->isEmpty())
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
			@else
			<table style="width:100%">
				<tr>
				  <th>Image</th>
				  <th>Heading</th>
				  <th>Order ID</th>
				  <th>Amount</th>
				  <th>Quantity</th>
				  <th>Total Price</th>
				  <th>Status</th>
				  <th>Payment type</th>
				  <th>Remove</th>
				</tr>
				@foreach ( $order as $data)
				<tr> 
					<td><img src={{$data->product_image}} alt="order image"></td>
				    <td>{{$data->product_head}}</td>
					<td>{{$data->order_id}}</td>
					<td>£{{$data->amount}}</td>
					<td>{{$data->quantity}}</td>
					<td>£{{$data->total}}</td>
					<td>{{$data->status}}</td>
					<td>{{$data->payment_method_type}}</td>
					<td><a href="{{url('/orderremove')}}/{{$data->id}}"><button class="button my-remove-btn">Remove</button></a></td>
				  </tr>
				@endforeach
				
			  </table>
			@endif
		</div>
	</section>
</body>
</html>
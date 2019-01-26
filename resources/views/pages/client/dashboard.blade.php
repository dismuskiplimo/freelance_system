@extends('layouts.client')

@section('title', 'Dashboard')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<div class="card">
					<img src="{{ empty(Auth::user()->image) ? asset('images/new-user.png') : asset('images/uploads/'.Auth::user()->image) }}" class ="img-full" alt="{{ Auth::user()->name }}">

					<h5><strong>{{ Auth::user()->name }} <small> <i class="fa fa-circle-o text-success"></i></small></strong></h5>
					<hr/>
					<h4><small>My orders</small></h4>
					<p>Total <span class = "pull-right"><strong>{{ count($orders) }}</strong></span></p>
					<p>Auction <span class = "pull-right"><strong>{{ count($orders_auction) }}</strong></span></p>
					<p>Active <span class = "pull-right"><strong>{{ count($orders_active) }}</strong></span></p>
				</div>	
			</div>

			<div class="col-lg-9">
				<div class="row">
					<div class="col-lg-12">
						@if(count(Auth::user()->notifications()->where('read_status', 0)->orderBy('created_at', 'DESC')->get()))
							@foreach(Auth::user()->notifications()->where('read_status', 0)->orderBy('created_at', 'DESC')->limit(3)->get() as $notification)
								<a href="{{ route('getClientNotification', ['id' => $notification->id]) }}">
									<div class="well{{ $notification->read_status == 0 ? ' text-info text-bold': ' text-black' }}">
										<strong>{{ $notification->author->username }}</strong> {{ $notification->message }} <br>
										<small>{{ $notification->created_at->diffForHumans() }}</small>
									</div>
								</a>
							@endforeach
						@else

							<div class="card">
								<h4>No new notifications <small><a href="{{ route('getClientNotifications') }}" >Notifications History</a></small></h4>
							</div>

						@endif
						
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						@if(count($orders_active))
							<h4>Active orders <small><small><a href="{{ route('getClientOrders') }}">see all</a></small></small></h4><br>
						
							@foreach($orders_active as $order)
								<div class="card">
									<div class="row" style = "margin-bottom:-10px">
										<div class="col-lg-12">
											<p><a href = "{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><strong class="theme-color">{{ $order->title }}</strong></a></p>
											<p>{{ $order->assignment_type ? $order->assignment_type->name : '' }}, {{ $order->discipline ? $order->discipline->name : '' }}</p>
										</div>
									</div>

									<hr />	
									

									<div class="row">
										<div class="col-lg-3 border-right"><i class="fa fa-file"></i> {{ ucfirst(strtolower($order->status)) }}</div>
										<div class="col-lg-3"><i class="fa fa-clock-o"></i> Deadline: {{ $order->deadline->toDateString() }}</div>
										<div class="col-lg-3"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><span class = "theme-color">{{ $order->bids }} Bids</span></a></div>
										<div class="col-lg-3 border-left"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><i class="fa fa-comments"></i> Comments 0</a></div>
									</div>
								</div>
							@endforeach
						@endif

						@if(count($orders_auction))
							<br><h4>Orders in auction <small><small><a href="{{ route('getClientOrders') }}">see all</a></small></small></h4><br>
						
							@foreach($orders_auction as $order)
								<div class="card">
									<div class="row" style = "margin-bottom:-10px">
										<div class="col-lg-12">
											<p><a href = "{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><strong class="theme-color">{{ $order->title }}</strong></a></p>
											<p>{{ $order->assignment_type ? $order->assignment_type->name : '' }}, {{ $order->discipline ? $order->discipline->name : '' }}</p>
										</div>
									</div>

									<hr />	
									

									<div class="row">
										<div class="col-lg-3 border-right"><i class="fa fa-file"></i> {{ ucfirst(strtolower($order->status)) }}</div>
										<div class="col-lg-3"><i class="fa fa-clock-o"></i> Deadline: {{ $order->deadline->toDateString() }}</div>
										<div class="col-lg-3"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><span class = "theme-color">{{ $order->bids }} Bids</span></a></div>
										<div class="col-lg-3 border-left"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><i class="fa fa-comments"></i> Comments 0</a></div>
									</div>
								</div>
							@endforeach
						@endif

						@if(!count($orders_active) && !count($orders_auction))

							<div class="card text-center">
								<div class="row padding-tb-30">
									<h3>You have no existing orders at this time<br />
										<small><span class = "text-black">{{ count(\App\User::where('user_type', 'WRITER')->where('active',1)->get()) }}</span> writers are waiting for your assignments</small>
									</h3><br />
									<p><a href="{{ route('getClientCreateOrder') }}" class="btn btn-primary">CREATE AN ORDER</a></p><br />
								</div>

								<hr />
								
								<div class="row infographics padding-tb-30">
									<h4 class = "padding-b-30">How it Works</h4>
									<div class="col-lg-3">
										<i class="fa fa-edit"></i>
										<h5>Create an order</h5>
									</div>
									<div class="col-lg-3">
										<i class="fa fa-user-plus"></i>
										<h5>Choose a writer</h5>
									</div>
									<div class="col-lg-3">
										<i class="fa fa-money"></i>
										<h5>Make payment</h5>
									</div>
									<div class="col-lg-3">
										<i class="fa fa-smile-o"></i>
										<h5>Receive completed assignment in time</h5>
									</div>
								</div>

								<hr />

								<div class="row padding-tb-30">
									<h4 class = "theme-color"><b>{{ $days_guranteed }} Days Gurantee</b></h4>
									<p>After receiving your academic assignment, the Writer will make corrections to the <br />
									completed order at no charge during the Warranty period.</p> 
								</div>

								<hr />

								<div class="row padding-tb-30">
									<h6>
										If you are having difficulties, please <a href = "" class = "tawk-button">contact our Customer Service Support</a> </p><br />
										Our staff will be happy to assist you. </h6>

									</p> 
								</div>

							</div>
						@endif
					</div>
				</div>

				
			</div>

		</div>
	</div>
@endsection
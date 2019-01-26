@extends('layouts.writer')

@section('title', 'Dashboard')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				@include('includes.writer.sidebar-profile')
			</div>
			<div class="col-md-6">
				@if(count(Auth::user()->notifications()->where('read_status', 0)->orderBy('created_at', 'DESC')->get()))
					@foreach(Auth::user()->notifications()->where('read_status', 0)->orderBy('created_at', 'DESC')->limit(3)->get() as $notification)
						<a href="{{ route('getWriterNotification', ['id' => $notification->id]) }}">
							<div class="well{{ $notification->read_status == 0 ? ' text-info text-bold': ' text-black' }}">
								<strong>{{ $notification->author->username }}</strong> {{ $notification->message }} <br>
								<small>{{ $notification->created_at->diffForHumans() }}</small>
							</div>
						</a>
					@endforeach
				@else

					<div class="card">
						<h4>No new notifications <small><a href="{{ route('getWriterNotifications') }}" >Notifications History</a></small></h4>
					</div>

				@endif
				
				@if(count($active_orders))
					

					
					<h4>Active Orders</h4>
					@foreach($active_orders as $assignment)
						<div class="card">
							<small><small>
							<table class="full-width">
								
								<tr class = "text-bold">
									<td><i class="fa fa-envelope theme-color medium-size"></i></td>
									<td colspan="5"><a href="{{ route('getSingleWriterOrder', ['id'=>$assignment->id]) }}">{{ $assignment->title }}</a></td>
								</tr>

								<tr class = "text-itallic">
									<td></td>
									<td></td>
									<td>Posted</td>
									<td>Deadline</td>
									<td>Bids</td>
									<td>Price</td>
								</tr>
								<tr class = "text-bold">
									<td></td>
									<td>{{ $assignment->assignment_type ? $assignment->assignment_type->name : '' }}, {{ $assignment->discipline ? $assignment->discipline->name : '' }}</td>
									<td>{{ $assignment->created_at->diffForHumans() }}</td>
									<td>{{ $assignment->deadline->diffForHumans() }}</td>
									<td><a href="{{ route('getSingleWriterOrder', ['id'=>$assignment->id]) }}">{{ $assignment->bids }}</a></td>
									<td>${{ number_format($assignment->price) }}</td>
								</tr>
							</table>
							</small></small>
						</div>
					@endforeach

					

				@else
					<div class="card text-center">
						<h4>There are no pending orders requiring your attention at this time.</h4>

						<hr>

						<p class="text-muted">Find assignments and earn money with {{ env('APP_NAME') }}!</p>

						<p><a href="{{ route('getOrderSearch') }}" class="btn btn-primary margin-tb-30">FIND AN ORDER</a></p>

						<hr>
						<small>
							<p>If something is not working, please contace our <a href="" class = "tawk-button">Customer Service Support</a>.</p>
							<p>Our staff will be happy to assist you</p>
						</small>
					</div>
				@endif
			</div>
			<div class="col-md-3">
				@include('includes.writer.sidebar-assignments')
			</div>
		</div>
	</div>
@endsection
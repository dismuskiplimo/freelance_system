@extends('layouts.writer')

@section('title', 'Orders')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="card">
					<h4>Orders</h4>
					<div class="list-group">
						<a href="#active-orders" aria-controls="active-orders" role="tab" data-toggle="tab" class="list-group-item">Active <span class="badge">{{ count($active_orders) }}</span></a>
						<a href="#completed-orders" aria-controls="completed-orders" role="tab" data-toggle="tab" class="list-group-item">Completed <span class="badge">{{ count($completed_orders) }}</span></a>
						<a href="#rejected-orders" aria-controls="rejected-orders" role="tab" data-toggle="tab" class="list-group-item">Rejected <span class="badge">{{ count($rejected_orders) }}</span></a>
						
					</div>
				</div>
			</div>
			<div class="col-md-6">
				
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="intro">
						<div class="card text-center">
					
							<h4>All Orders and assignments, on which you have placed bids, or have added commentaries, will appear under the "Active section."</h4>

							<hr>

							<p class="text-muted">This section lets you keep track of Assignment Status, of those assignments, which are still in the auction, where you are a potential candidate for the completion.</p>

							<p><a href="{{ route('getOrderSearch') }}" class="btn btn-primary margin-tb-30">ASSIGNMENT SEARCH</a></p>

							<hr>
							<small>
								<p>If something is not working, please contace our <a href="" class = "tawk-button">Customer Service Support</a>.</p>
								<p>Our staff will be happy to assist you</p>
							</small>
						
						
						</div>
					</div>

					<div role="tabpanel" class="tab-pane" id="active-orders">
						<h4>Active Orders ({{ count($active_orders) }})</h4>
						@if(count($active_orders))
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

						@endif
					</div>

					<div role="tabpanel" class="tab-pane" id="completed-orders">
						<h4>Completed Orders ({{ count($completed_orders) }})</h4>
						@if(count($completed_orders))
							@foreach($completed_orders as $assignment)
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
											<td>Completed</td>
											
											<td>Price</td>
										</tr>
										<tr class = "text-bold">
											<td></td>
											<td>{{ $assignment->assignment_type ? $assignment->assignment_type->name : '' }}, {{ $assignment->discipline ? $assignment->discipline->name : '' }}</td>
											<td>{{ $assignment->created_at->diffForHumans() }}</td>
											<td>{{ $assignment->completed_at->diffForHumans() }}</td>
											
											<td>${{ number_format($assignment->price) }}</td>
										</tr>
									</table>
									</small></small>
								</div>
							@endforeach

						@endif
					</div>

					<div role="tabpanel" class="tab-pane" id="rejected-orders">
						<h4>Rejected Orders ({{ count($rejected_orders) }})</h4>
					</div>
				</div>

				
			</div>
			<div class="col-md-3">
				@include('includes.writer.sidebar-assignments')
			</div>
		</div>
	</div>
@endsection
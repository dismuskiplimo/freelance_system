@extends('layouts.client')

@section('title', 'Orders')

@section('content')
	<div class="container">
		<div class="col-lg-3">
			<div class="card">
				<h4><small>Orders</small></h4>
				<div class="list-group">
					<a href="#orders-auction" aria-controls = "orders-auction" class = "list-group-item active" role="tab" data-toggle="tab">Auction <span class = "badge small">{{ count($orders_auction) }}</span></a>
					<a href="#orders-active" aria-controls = "orders-active" class = "list-group-item" role="tab" data-toggle="tab">In Progress <span class = "badge small">{{ count($orders_active) }}</span></a>
					<a href="#orders-complete" aria-controls = "orders-complete" class = "list-group-item" role="tab" data-toggle="tab">Completed <span class = "badge small">{{ count($orders_complete) }}</span></a>
					<a href="#orders-expired" aria-controls = "orders-expired" class = "list-group-item" role="tab" data-toggle="tab">Expired <span class = "badge small">{{ count($orders_expired) }}</span></a>
				

				</div>
			</div>

			<div class="card">
				<h4><small>Calendar</small></h4>
				
			</div>
		</div>
		<div class="col-lg-9">
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="orders-auction">
					<h4>Orders in auction ({{ count($orders_auction) }})</h4>
					@if(count($orders_auction))
						@foreach($orders_auction as $order)
							<div class="card">
								<div class="row" style = "margin-bottom:-10px">
									<div class="col-lg-12">
										<p><a href = "{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><strong class="theme-color">{{ $order->title }}</strong></a> <span class="pull-right text-bold">{{ $order->price == null || empty($order->price) ? 'negotiable' : '$' . number_format($order->price) }}</span></p>
										<p>{{ $order->assignment_type ? $order->assignment_type->name : '' }}, {{ $order->discipline ? $order->discipline->name : '' }}</p>
									</div>
								</div>

								<hr />	
								

								<div class="row">
									<div class="col-lg-3 border-right"><i class="fa fa-file"></i> {{ ucfirst(strtolower($order->status)) }}</div>
									<div class="col-lg-3"><i class="fa fa-clock-o"></i> Deadline: {{ $order->deadline->diffForHumans() }}</div>
									<div class="col-lg-3"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><span class = "theme-color">{{ $order->bids }} Bids</span></a></div>
									<div class="col-lg-3 border-left"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><i class="fa fa-comments"></i> Comments 0</a></div>
								</div>
							</div>
						@endforeach
					@endif	
				</div>

				<div role="tabpanel" class="tab-pane fade" id="orders-active">
					<h4>Orders in progress ({{ count($orders_active) }})</h4>
					@if(count($orders_active))
						@foreach($orders_active as $order)
							<div class="card">
								<div class="row" style = "margin-bottom:-10px">
									<div class="col-lg-12">
										<p><a href = "{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><strong class="theme-color">{{ $order->title }}</strong></a> <span class="pull-right text-bold">Assigned to <a href="{{ route('getClientWriter', ['slug' => $order->writer->username]) }}">{{ $order->writer->username }}</a>, {{ $order->assigned_at->diffForHumans() }}</span></p>
										<p>{{ $order->assignment_type ? $order->assignment_type->name : '' }}, {{ $order->discipline ? $order->discipline->name : '' }} <span class = "pull-right text-bold">for ${{ number_format($order->price,2) }}</span></p>
									</div>
								</div>

								<hr />	
								

								<div class="row">
									<div class="col-lg-3 border-right"><i class="fa fa-file"></i> {{ ucfirst(strtolower($order->status)) }}</div>
									<div class="col-lg-3"><i class="fa fa-clock-o"></i> Deadline: {{ $order->deadline->diffForHumans() }}</div>
									<div class="col-lg-3"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><span class = "theme-color">{{ $order->bids }} Bids</span></a></div>
									<div class="col-lg-3 border-left"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><i class="fa fa-comments"></i> Comments 0</a></div>
								</div>
							</div>
						@endforeach
					@endif	
				</div>
				<div role="tabpanel" class="tab-pane fade" id="orders-complete">
					<h4>Completed orders ({{ count($orders_complete) }})</h4>
					@if(count($orders_complete))
						@foreach($orders_complete as $order)
							<div class="card">
								<div class="row" style = "margin-bottom:-10px">
									<div class="col-lg-12">
										<p><a href = "{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><strong class="theme-color">{{ $order->title }}</strong></a> <span class="pull-right text-bold">Completed by <a href="{{ route('getClientWriter', ['slug' => $order->writer->username]) }}">{{ $order->writer->username }}</a></span></p>
										<p>{{ $order->assignment_type ? $order->assignment_type->name : '' }}, {{ $order->discipline ? $order->discipline->name : '' }} <span class = "pull-right text-bold">for ${{ number_format($order->price,2) }}</span></p>
									</div>
								</div>

								<hr />	
								

								<div class="row">
									<div class="col-lg-4"><i class="fa fa-clock-o"></i> Completed: {{ $order->completed_at->toDateString() }}</div>
									<div class="col-lg-4 border-left"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><span class = "theme-color">{{ $order->bids }} Bids</span></a></div>
									<div class="col-lg-4 border-left"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><i class="fa fa-comments"></i> Comments 0</a></div>
								</div>
							</div>
						@endforeach
					@endif	
				</div>

				<div role="tabpanel" class="tab-pane fade" id="orders-expired">
					<h4>Expired orders ({{ count($orders_expired) }})</h4>
					<p class="text-muted">Orders that were still in auction but passed the deadline set.</p>
					@if(count($orders_expired))
						@foreach($orders_expired as $order)
							<div class="card">
								<div class="row" style = "margin-bottom:-10px">
									<div class="col-lg-12">
										<p><a href = "{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><strong class="theme-color">{{ $order->title }}</strong></a> <span class="pull-right"><a href="" data-toggle="modal" data-target="#extend-deadline-modal-{{ $order->id }}" class="btn btn-info">Extend deadline</a></span></p>
										<p>{{ $order->assignment_type ? $order->assignment_type->name : '' }}, {{ $order->discipline ? $order->discipline->name : '' }}</p>
									</div>
								</div>

								<hr />	
								

								<div class="row">
									<div class="col-lg-3 border-right"><i class="fa fa-file"></i> {{ ucfirst(strtolower($order->status)) }}</div>
									<div class="col-lg-3 text-danger"><i class="fa fa-clock-o"></i> Deadline: {{ $order->deadline->diffForHumans() }}</div>
									<div class="col-lg-3"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><span class = "theme-color">{{ $order->bids }} Bids</span></a></div>
									<div class="col-lg-3 border-left"><a href="{{ route('getSingleClientOrder',['id'=>$order->id]) }}"><i class="fa fa-comments"></i> Comments 0</a></div>
								</div>
							</div>

							<div class="modal fade" id = "extend-deadline-modal-{{ $order->id }}">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<form action="{{ route('postUpdateDeadline',['id'=>$order->id]) }}" method = "POST">
											{{ csrf_field() }}
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">Extend deadline for "{{ $order->title }}"</h4>
											</div>
											<div class="modal-body">
												
												<div class="form-group">
													<label for="">New deadline</label>
													<input type="text" name = "deadline" class="form-control deadline" required />
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary">Extend deadline</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						@endforeach
					@endif	
				</div>
			</div>
		</div>
	</div>
@endsection
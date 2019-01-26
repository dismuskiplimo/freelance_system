@extends('layouts.admin')

@section('title', 'Withdrawal Requests')

@section('content')

@include('includes.admin.withdrawal-requests-nav')

<div class="row">
	<div class="col-xs-12">
		@if(count($requests))
			<div class="card">
			<table class="table table-striped">
				@if($type == 'pending')
					<thead>
						<tr>
							<td>Amount</td>
							<td>Recepient</td>
							<td>Date requested</td>
							<td>PayPal email</td>
							<td></td>	
							<td></td>	
						</tr>	
					</thead>
					<tbody>
						@foreach($requests as $request)
							<tr>
								<td>${{ number_format($request->amount) }}</td>
								<td>
									<a href="" data-toggle="modal" data-target="#user-{{ $request->id }}"><strong>{{ $request->user->username }}</strong></a>
									<div class="modal fade" id = "user-{{ $request->id }}">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title">Transaction History</h4>
												</div>
												<div class="modal-body">
													<h4>Account Balance (${{ number_format($request->user->balance,2) }})</h4>
													@if(count(App\Transaction::where('from_id', $request->user->id)->orWhere('to_id',$request->user->id)->orderBy('created_at','DESC')->get()))
														<table class="table table-striped">
															<thead>
																<tr>
																	<th>Amount</th>
																	<th>Created at</th>
																	<th>Transacted at</th>
																	<th>Incoming</th>
																	<th>Outgoing</th>
																	<th>Status</th>
																</tr>
																
															</thead>

															<tbody>
																@foreach(App\Transaction::where('from_id', $request->user->id)->orWhere('to_id',$request->user->id)->orderBy('created_at','DESC')->get() as $transaction)
																	<tr>
																		<td>${{ number_format($transaction->amount,2) }}</td>
																		<td>{{ $transaction->created_at }}</td>
																		<td>{{ $transaction->transferred_at }}</td>
																		<td><span class="text-success">{{ $transaction->type == "INCOMING" ? '$'. number_format($transaction->amount,2) : '' }}</span></td>
																		<td><span class="text-danger">{{ $transaction->type == "OUTGOING" ? '- $'. number_format($transaction->amount,2) : '' }}</span></td>
																		<td>{{ $transaction->status }}</td>
																	</tr>
																@endforeach
															</tbody>

														</table>
													@endif
															
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												</div>
											</div>
											
										</div>
									</div>	
								</td>
								
								<td>{{ $request->created_at }}</td>
								<td><strong>{{ $request->user->paypal_email ?$request->user->paypal_email : $request->user->email   }}</strong></td>
								
								<td>
									<a href="" data-toggle="modal" data-target="#approve-{{ $request->id }}" class="btn btn-success btn-sm pull-right">Approve</a>
									
									<div class="modal fade" id = "approve-{{ $request->id }}">
										<div class="modal-dialog">
											<form action="{{ route('postApproveWithdrawalRequest',['id'=>$request->id]) }}" method = "POST">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title">Approve Withdrawal request</h4>
													</div>
													<div class="modal-body">
														<h3 class="text-center">Send ${{ number_format($request->amount,2) }} to PayPal account <br> <span class="text-success">{{ $request->user->paypal_email ?$request->user->paypal_email : $request->user->email   }}</span></h3>
														{{ csrf_field() }}
																
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary">Aprove request</button>
													</div>
												</div>
											</form>
										</div>
									</div>	
								</td>
								<td>
									<a href="" data-toggle="modal" data-target="#reject-{{ $request->id }}" class="btn btn-danger btn-sm pull-right">Reject</a>
									<div class="modal fade" id = "reject-{{ $request->id }}">
										<div class="modal-dialog">
											<form action="{{ route('postRejectWithdrawalRequest',['id'=>$request->id]) }}" method = "POST">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title">Reject Withdrawal request</h4>
													</div>
													<div class="modal-body">
														{{ csrf_field() }}
														<div class="form-group">
															<label for="">Reason</label>
															<textarea name="message" required = "required" rows="3" class="form-control required border-input"></textarea>
														</div>
														
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary">Reject request</button>
													</div>
												</div>
											</form>
										</div>
									</div>	
								</td>
							</tr>
						@endforeach
					</tbody>
				@elseif($type == 'complete')
					<thead>
						<tr>
							<td>Amount</td>
							<td>Recepient</td>
							<td>Date requested</td>
							<td>Date approved</td>
							<td>Approved by</td>	
						</tr>	
					</thead>
					<tbody>
						@foreach($requests as $request)
							<tr>
								<td>${{ number_format($request->amount) }}</td>
								<td><strong>{{ $request->user->username }}</strong></td>
								<td>{{ $request->created_at }}</td>
								<td>{{ $request->approved_at }}</td>
								<td>{{ $request->admin->username }}</td>
							</tr>
						@endforeach
					</tbody>
				@else
					<thead>
						<tr>
							<td>Amount</td>
							<td>Recepient</td>
							<td>Date requested</td>
							<td>Date rejected</td>
							<td>Rejected by</td>	
							<td>Reason</td>	
						</tr>	
					</thead>
					<tbody>
						@foreach($requests as $request)
							<tr>
								<td>${{ number_format($request->amount) }}</td>
								<td><strong>{{ $request->user->username }}</strong></td>
								<td>{{ $request->created_at }}</td>
								<td>{{ $request->updated_at }}</td>
								<td>{{ $request->admin->username }}</td>
								<td>{{ $request->message }}</td>
							</tr>
						@endforeach
					</tbody>

				@endif
			</table>
			{{ $requests->links() }}
			</div>
		@endif
	</div>
</div>
    
@endsection
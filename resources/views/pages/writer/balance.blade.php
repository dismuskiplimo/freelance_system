@extends('layouts.writer')

@section('title', 'Balance')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				@include('includes.writer.sidebar-profile')
			</div>
			<div class="col-md-9">
				<div class="card">
					<div class="row">
						<div class="col-md-6 text-center">
							<h1 class = "text-success">$ {{ number_format(Auth::user()->balance,2) }}</h1><br>
							<a href="{{ route('getWriterWithdraw') }}" class="btn btn-success"><i class="fa fa-download medium-size"></i> WITHDRAW FUNDS</a>
						</div>
						<div class="col-md-6 text-center">
							<h1 class = "text-warning">$ {{ number_format(Auth::user()->incoming_money()->where('status', 'PENDING')->where('type', 'INCOMING')->sum('amount')) }}</h1><br>
							<p class="text-muted">
								Funds currently on hold. They will be transferred to your account after the <a href="">warranty</a> period has expired
							</p>
						</div>

						<div class="col-lg-12 margin-tb-30">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs margin-b-20" role="tablist">
								<li role="presentation" class="active"><a href="#withdrawal-requests" aria-controls="withdrawal-requests" role="tab" data-toggle="tab">Withdrawal requests</a></li>
								<li role="presentation"><a href="#funds-on-hold" aria-controls="funds-on-hold" role="tab" data-toggle="tab">Funds on Hold</a></li>
								<li role="presentation"><a href="#funds-history" aria-controls="funds-history" role="tab" data-toggle="tab">Incoming</a></li>
								<li role="presentation"><a href="#outgoing" aria-controls="outgoing" role="tab" data-toggle="tab">Outgoing</a></li>
								
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="withdrawal-requests">
									<table class="table table-responsive full-width">
										<thead>
											<tr class="info">
												<th>WRQ ID</th>
												<th>TRX ID</th>
												<th>Amount</th>
												<th>Payment Method</th>
												<th>Account</th>
												<th>Transacted on</th>
												<th>Status</th>
											</tr>
										</thead>

										<tbody>
											@if(count($withdrawal_requests))
												@foreach($withdrawal_requests as $withdrawal_request)
													<tr>
														<td>{{ $withdrawal_request->id }}</td>
														<td>{{ $withdrawal_request->transaction_id }}</td>
														<td>${{ number_format($withdrawal_request->amount,2) }}</td>
														
														<td>paypal</td>
														<td>{{ $withdrawal_request->user->email }}</td>
														<td>{{ $withdrawal_request->created_at }}</td>
														<td>{{ $withdrawal_request->status }}</td>
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
								<div role="tabpanel" class="tab-pane" id="funds-history">
									<table class="table table-responsive full-width">
										<thead>
											<tr class="info">
												<th>Amount</th>
												<th>Status</th>
												<th>Ref</th>
												<th>Description</th>
												<th>Transacted</th>
												<th>Received</th>
												
											</tr>
										</thead>

										<tbody>
											@if(count($transactions))
												@foreach($transactions as $transaction)
													<tr>
														<td>${{ number_format($transaction->amount,2) }}</td>
														<td>{{ $transaction->status }}</td>
														<td>{{ $transaction->id }}</td>
														<td>{{ $transaction->details }}</td>
														<td>{{ $transaction->created_at }}</td>
														<td>{{ $transaction->transferred_at }}</td>
														
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
								<div role="tabpanel" class="tab-pane" id="funds-on-hold">
									<table class="table table-responsive full-width">
										<thead>
											<tr class="info">
												
												<th>Title</th>
												<th>Amount</th>
												<th>Date Transacted</th>
												<th>Matures at</th>
											</tr>
										</thead>

										<tbody>
											@if(count($funds_on_hold))
												@foreach($funds_on_hold as $fund)
													<tr>
														
														<td>{{ $fund->details }}</td>
														<td>$ {{ number_format($fund->amount) }}</td>
														<td>{{ $fund->created_at }}</td>
														<td>{{ $fund->matures_at }}</td>
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>

								<div role="tabpanel" class="tab-pane" id="outgoing">
									<table class="table table-responsive full-width">
										<thead>
											<tr class="info">
												<th>Amount</th>
												<th>Status</th>
												<th>Ref</th>
												<th>Description</th>
												<th>Transacted</th>
												<th>Approved</th>
												
											</tr>
										</thead>

										<tbody>
											@if(count($outgoing))
												@foreach($outgoing as $transaction)
													<tr>
														<td>${{ number_format($transaction->amount,2) }}</td>
														<td>{{ $transaction->status }}</td>
														<td>{{ $transaction->id }}</td>
														<td>{{ $transaction->details }}</td>
														<td>{{ $transaction->created_at }}</td>
														<td>{{ $transaction->transferred_at ? : '' }}</td>
														
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>


								
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
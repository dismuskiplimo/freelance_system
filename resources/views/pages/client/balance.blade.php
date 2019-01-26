@extends('layouts.client')

@section('title', 'Balance')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h4>Available Balance</h4>
				<div class="card">
					<div class="inner-grey">
						<h2>${{ number_format(Auth::user()->balance,2) }}
	
							<a href="" data-toggle="modal" data-target="#add-funds-modal" class="btn btn-success" style = "margin-left:40px">
								<i class="i fa fa-money"></i> DEPOSIT FUNDS
							</a>

							<small class = "pull-right"><a href = "{{ route('getClientWithdraw') }}">withdraw funds</a></small>
						</h2>
					</div>

					<br /><h4 class="text-bold">Incoming</h4>
					
					<table class = "table padding-tb-30">
						<thead>
							<tr class = "info">
								<th>Reference</th>
								<th>Amount</th>
								<th>Description</th>
								<th>Date</th>
								<th>Type</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							@if(count($incoming_transactions))
								@foreach($incoming_transactions as $transaction)
									<tr>
										<td>#{{ $transaction->id }}</td>
										<td>${{ number_format($transaction->amount,2) }}</td>
										<td>{{ $transaction->details }}</td>
										<td>{{ $transaction->created_at }}</td>
										<td>{{ $transaction->type }}</td>
										<td>{{ $transaction->status }}</td>
										
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>

					<br /><h4 class="text-bold">Outgoing</h4>
					
					<table class = "table padding-tb-30">
						<thead>
							<tr class = "info">
								<th>Reference</th>
								<th>Amount</th>
								<th>Recepient</th>
								<th>Description</th>
								<th>Date</th>
								<th>Type</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							@if(count($outgoing_transactions))
								@foreach($outgoing_transactions as $transaction)
									<tr>
										<td>#{{ $transaction->id }}</td>
										<td>${{ number_format($transaction->amount,2) }}</td>
										<td>{{ $transaction->to ? $transaction->to->username : env('APP_NAME') }}</td>
										<td>{{ $transaction->details }}</td>
										<td>{{ $transaction->created_at }}</td>
										<td>{{ $transaction->type }}</td>
										<td>{{ $transaction->status }}</td>
										
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id = "add-funds-modal">
		<div class="modal-dialog">
			<form action="{{ route('postClientAddFunds') }}" method = "POST">
				{{ csrf_field() }}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Add funds</h4>
					</div>

					<div class="modal-body">
						<div class="form-group">
							<label for="">Amount you wish to add</label>
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input type="number" name = "amount" class = "form-control" required placeholder="amount" >
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary pull-right">Add funds</button>
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection
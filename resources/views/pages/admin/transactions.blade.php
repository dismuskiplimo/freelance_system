@extends('layouts.admin')

@section('title', 'Transactions')

@section('content')

@include('includes.admin.transactions-nav')

@if($type == 'paypal')
	@if(count($paypals))
		<table class="table table-responsive table-striped">
			<thead>
				<tr>
					<th>TRX ID</th>
					<th>User</th>
					<th>Payment Id</th>
					<th>Payer Id</th>
					<th>Token</th>
					<th>Type</th>
					<th>Amount</th>
				</tr>
			</thead>

			<tbody>
				@foreach($paypals as $paypal)
					<tr>
						<td>#{{ $paypal->id }}</td>
						<td><a href="{{ $paypal->user ? route('getAdminUser',['id'=>$paypal->user->id]) : '' }}">{{ $paypal->user ? $paypal->user->username : 'Unknown' }}</a></td>
						<td>{{ $paypal->payment_id }}</td>
						<td>{{ $paypal->payer_id }}</td>
						<td>{{ $paypal->token }}</td>
						<td>{{ $paypal->type }}</td>
						<td>${{ number_format($paypal->amount,2) }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		{{ $paypals->links() }}
	@endif
@elseif($type == 'insite')
	@if(count($transactions))
		<table class="table table-responsive table-striped">
			<thead>
				<tr>
					<th>TRX ID</th>
					<th>To</th>
					<th>From</th>
					<th>Details</th>
					<th>Status</th>
					<th>Type</th>
					<th>Amount</th>
					<th>Frozen</th>
					<th>Transacted at</th>
					<th>Completed at</th>
					<th>Matures at</th>
				</tr>
			</thead>

			<tbody>
				@foreach($transactions as $transaction)
					<tr>
						<td>#{{ $transaction->id }}</td>
						<td><a href="{{ $transaction->to ? route('getAdminUser',['id'=>$transaction->to->id]) : '' }}">{{ $transaction->to ? $transaction->to->username : '' }}</a></td>
						<td><a href="{{ $transaction->from ? route('getAdminUser',['id'=>$transaction->from->id]) : '' }}">{{ $transaction->from ? $transaction->from->username : 'Unknown' }}</a></td>
						
						<td>{{ $transaction->details }}</td>
						<td>{{ $transaction->status }}</td>
						<td>{!! $transaction->type == 'INCOMING' ? '<span class = "text-success">INCOMING</span>' : '<span class = "text-danger">OUTGOING</span>' !!}</td>
						
						<td>${{ number_format($transaction->amount,2) }}</td>
						<td>{{ $transaction->frozen ? 'YES' : 'NO' }}</td>
						<td>{{ $transaction->created_at }}</td>
						<td>{{ $transaction->transreffed_at }}</td>
						<td>{{ $transaction->mautres_at }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		{{ $transactions->links() }}
	@endif
@endif
    
@endsection
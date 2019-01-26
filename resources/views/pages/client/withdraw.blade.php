@extends('layouts.client')

@section('title', 'Withdraw')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h4 class = "margin-b-20">Withdraw funds</h4>

				@if(Auth::user()->balance > $threshold)
					<div class="card">
						<h3 class = "text-success">Available balance ${{ number_format(Auth::user()->balance) }}</h3><br>
						<a href="" data-toggle="modal" data-target="#payout-modal" class="btn btn-primary btn-lg"><i class="fa fa-money big-text"></i> Withdraw cash</a>
					</div>

					<div class="modal fade" id = "payout-modal">
						<div class="modal-dialog">
							<div class="modal-content">
								<form action="{{ route('postClientWithdrawRequest') }}" method = "post">
									{{ csrf_field() }}
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Withdraw funds</h4>
									</div>
									<div class="modal-body">
										
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<label for="">Amount</label>
													<div class="input-group">
														<span class="input-group-addon">$</span>
														<input type="number" name = "amount" min="{{ floor($threshold) }}" max="{{ floor(Auth::user()->balance) }}" class = "form-control" required />
													</div>
													
												</div>
											</div>
											
										</div>
										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<button type="submit" class="btn btn-primary">Withdraw cash</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				
				@else
					<div class="card">
						<p>You cannot withdraw funds at this time. You have less than ${{ number_format($threshold,2) }} in your account.</p>
						<span>Actual balance : <span class="text-danger text-bold">$ {{ Auth::user()->balance }}</span></span>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection
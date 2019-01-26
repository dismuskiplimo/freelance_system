@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
	
	<div class="row">
		
		<div class="col-sm-6">
			<div class="card">
				<div class="header">
					<h4 class="title">Prefferences</h4>
				</div>
				<div class="content">
					<form action="{{ route('postSitePrefferences') }}" method = "POST">
						{{ csrf_field() }}

						<div class="form-group">
							<label for="">PayPal email</label>
							<input type="email" name = "paypal_email" value = "{{ old('paypal_email') ? old('paypal_email') : App\Settings::where('name','paypal_email')->first()->value }}" class = "form-control border-input required" required>
						</div>

						<div class="form-group">
							<label for="">Minimum amount a writer can withdraw</label>
							<div class="input-group">
								<span class="input-group-addon text-success">$</span>
								<input type="number" name = "minimum_threshold" value = "{{ old('minimum_threshold') ? old('minimum_threshold') : App\Settings::where('name','minimum_threshold')->first()->value }}" class = "form-control border-input required" required>
								
							</div>
						</div>

						<div class="form-group">
							<label for="">Time for money to mature</label>
							<div class="input-group">
								<input type="number" name = "mature_duration" value = "{{ old('mature_duration') ? old('mature_duration') : App\Settings::where('name','mature_duration')->first()->value }}" class = "form-control border-input required" required>
								<span class="input-group-addon">Days</span>
							</div>
						</div>

						<div class="form-group">
							<label for="">Commission charged on writer and client</label>
							<div class="input-group">
								<input min = "0" max = "100" type="number" name = "commission_percent" value = "{{ old('commission_percent') ? old('commission_percent') : App\Settings::where('name','commission_percent')->first()->value }}" class = "form-control border-input required" required>
								<span class="input-group-addon">%</span>
							</div>
						</div>

						<div class="form-group">
							<button class="btn btn-fill btn-success">Save</button>
						</div>
					</form>
				</div>
			</div>

			
			
			
		</div>

		<div class="col-sm-6">
			<div class="card">
				<div class="header">
					<h4 class="title">Contact info</h4>
				</div>
				<div class="content">
					<form action="{{ route('postSiteContactInfo') }}" method = "POST">
						{{ csrf_field() }}

						<div class="form-group">
							<label for="">Support email</label>
							<input type="email" name = "support_email" value = "{{ old('support_email') ? old('support_email') : App\Settings::where('name','support_email')->first()->value }}" class = "form-control border-input required" required>
						</div>

						<div class="form-group">
							<label for="">Notification email</label>
							<input type="email" name = "notification_email" value = "{{ old('notification_email') ? old('notification_email') : App\Settings::where('name','notification_email')->first()->value }}"  class = "form-control border-input required" required>
						</div>

						<div class="form-group">
							<label for="">Phone number</label>
							<input type="text" name = "phone_number" value = "{{ old('phone_number') ? old('phone_number') : App\Settings::where('name','phone_number')->first()->value }}"  class = "form-control border-input required" required>
						</div>

						<div class="form-group">
							<button type = "submit" class="btn btn-fill btn-success">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    
@endsection
@if(Session::has('success'))
	<div class="row" style = "margin-top:-22px">
		<div class="col-sm-12">
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{!! Session::get('success') !!}
			</div>	
		</div>
	</div>
@endif

@if(Session::has('error'))
	<div class="row" style = "margin-top:-22px">
		<div class="col-sm-12">
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{!! Session::get('error') !!}
			</div>	
		</div>
	</div>
@endif

@if(count($errors) > 0)
	<div class="row" style = "margin-top:-22px">
		<div class="col-sm-12">
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>PLEASE CORRECT THE FOLLOWING ERRORS</strong>
				<ul>
				@foreach($errors->all() as $error)
					<li>{!! $error !!}</li>
				@endforeach
				</ul>
			</div>	
		</div>
	</div>
@endif






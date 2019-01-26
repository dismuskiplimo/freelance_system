@if(Session::has('success'))
	<div class = "container-fluid">
		<div class = "row">
			<div class = "alert alert-success" role = "alert">
				<div class = "container">
					<div class = "row">
						<div class = "col-lg-12">
							{{Session::get('success')}}
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
@endif

@if(Session::has('error'))
	<div class = "container-fluid">
		<div class = "row">
			<div class = "alert alert-danger" role = "alert">
				<div class = "container">
					<div class = "row">
						<div class = "col-lg-12">
							{{Session::get('error')}}
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
@endif

@if(count($errors) > 0)
	<div class = "container-fluid">
		<div class = "row">
			<div class = "alert alert-danger" role = "alert">
				<div class = "container">
					<div class = "row">
						<div class = "col-lg-12">
							<strong>PLEASE CORRECT THE FOLLOWING ERRORS</strong>
							<ul>
							@foreach($errors->all() as $error)
								<li>{{$error}}</li>
							@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endif
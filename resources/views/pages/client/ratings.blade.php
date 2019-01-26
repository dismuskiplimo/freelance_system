@extends('layouts.client')

@section('title', 'Writer Ratings')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<div class="card theme-color bold">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h4 class="panel-title text-bold">
								<a href = "" class = "btn-block">
								Disciplines
								</a>
							</h4>
						</div>
					</div>

					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-info">
							<div class="panel-heading" role="tab" id="headingOne">
								<p class="panel-title text-bold">
									<a role="button" class = "collapsed btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									Formal and Natural Sciences
									</a>
								</p>
							</div>
							<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									<form action="" class = "" method = "">
										{{ csrf_field() }}
										<select name="" id="" class = "form-control">
											<option value="all">All disciplines</option>
										</select>
									</form>
								</div>
							</div>
						</div>
						
						<div class="panel panel-info">
							<div class="panel-heading" role="tab" id="headingTwo">
								<p class="panel-title text-bold">
									<a class="collapsed btn-block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									Humanities
									</a>
								</p>
							</div>
							
							<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
								<div class="panel-body">
									<form action="" class = "" method = "">
										{{ csrf_field() }}
										<select name="" id="" class = "form-control">
											<option value="all">All disciplines</option>
										</select>
									</form>
								</div>
							</div>
						</div>

						<div class="panel panel-info">
							<div class="panel-heading" role="tab" id="headingThree">
								<p class="panel-title text-bold">
									<a class="collapsed btn-block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									Social Sciences
									</a>
								</p>
							</div>
							<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
								<div class="panel-body">
									<form action="" class = "" method = "">
										{{ csrf_field() }}
										<select name="" id="" class = "form-control">
											<option value="all">All disciplines</option>
										</select>
									</form>
								</div>
							</div>
						</div>

						<div class="panel panel-info">
							<div class="panel-heading" role="tab" id="headingFour">
								<p class="panel-title text-bold">
									<a class="collapsed btn-block" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									Other disciplines
									</a>
								</p>
							</div>
							<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
								<div class="panel-body">
									<form action="" class = "" method = "">
										{{ csrf_field() }}
										<select name="" id="" class = "form-control">
											<option value="all">All disciplines</option>
										</select>
									</form>
								</div>
							</div>
						</div>
							
					</div>	
				</div>
			</div>
			<div class="col-lg-9">
				<div class="row">
					<div class="col-sm-12">
						<h4>Writer Ratings</h4>
						<div class="card">
							<form action="" class="form-horizontal">
								<div class="row">
									<div class="col-sm-9">
										<input type="text" name = "" class="form-control">
									</div>
									<div class="col-sm-3">
										<button type = "submit" class="btn btn-success btn-block"> FIND WRITER</button>
									</div>
								</div>
							</form>

							<div class="row">
								<div class="col-sm-12">
									<p class="text-muted padding-t-30">Found 6664 Writers in <span class="text-black">All disciplines</span> 
									<span class="pull-right">
										<span class="checkbox">
											<label><input type="checkbox" name =""> Online now</label>
										</span>
									</span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<div class="card-hover">
							<table class = "full-width table-responsive">
								<tr>
									<td>1</td>
									<td><img src="{{ asset('images/new-user-thumbnail.png') }}" class = "img-circle" style="margin:0 30px 0 10px;"></td>
									<td>
										<p>
											<span class = "theme-color">
												<strong><a href = "{{ route('getClientWriter', ['slug' => 'ffff']) }}">carkim</a></strong>
											</span>  
											<span class = "text-muted"> 
												<small><i class="fa fa-circle"></i></small> Today 02:09</span> 
										</p>
										<p class = "text-black">English Language, Business</p>
										<p class = "text-muted">Essay, Coursework</p>
									</td>
									<td>
										<div class = "text-right">
											<p><span><i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i></span></p>
											<p class="theme-color"><strong><a href = "" class = "btn btn-theme">Hire this writer</a></strong></p>
										</div>
										
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
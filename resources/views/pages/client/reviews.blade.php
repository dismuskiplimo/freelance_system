@extends('layouts.client')

@section('title', 'Reviews')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-9">
					<h3><a href="{{ route('getClientWriter',['slug'=>$user->username]) }}">{{ $user->username }}</a> / reviews</h3>

					<hr>
					<div class="row">
						<div class="col-md-8 margin-b-20">
							<form action="">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<select name="" id="" class = "form-control">
												<option value=""></option>
											</select>
										</div>
									</div>
									<div class="col-md-5">
										<div class="form-group">
											<select name="" id="" class = "form-control">
												<option value=""></option>
											</select>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group">
											<button type = "submit" class = "btn btn-info"> <i class="fa fa-search"></i> </button>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-2">
							<i class="fa fa-thumbs-up text-success"></i> <span class="text-muted">Positive</span> <span class="big-text text-bold">{{ count($user->ratings()->where('reaction', 'POSITIVE')->get()) }}</span>
						</div>

						<div class="col-md-2">
							<i class="fa fa-thumbs-down text-danger"></i> <span class="text-muted">Negative</span> <span class="big-text text-bold">{{ count($user->ratings()->where('reaction', 'NEGATIVE')->get()) }}</span>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							@if(count($user->ratings))
								@foreach($user->ratings()->orderBy('created_at')->get() as $rating)
								<div class="card">
									<table class = "full-width">
										<tbody>
											<tr>
												<td style= "width:10%">
													@if($rating->reaction == "POSITIVE")
														<i class="fa fa-thumbs-up text-success big-size"></i>
													@else
														<i class="fa fa-thumbs-down text-danger big-size"></i>
													@endif
												</td>
												<td style= "width:90%">
													<p><strong>{{ $rating->title }}</strong></p>
													<p>{{ $rating->content }}</p>
													<p>by <span class="theme-color"><strong>{{ $rating->client->username }}</strong></span>, <span class="text-muted">{{ $rating->created_at->diffForHumans() }}</span></p>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								@endforeach
							@endif
						</div>
					</div>
				
			</div>
		</div>
	</div>
@endsection
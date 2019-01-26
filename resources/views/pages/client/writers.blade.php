@extends('layouts.client')

@section('title', 'Conversation')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2 fullscreen">
				<h4>Writer Ratings</h4><br>

				<div class="row">
					<div class="col-sm-12">
						
						<div class="card">
							<form action="{{ route('getSearchWriter') }}" method = "GET" >
								
								<div class="row">
									<div class="col-sm-9">
										<div class="form-group">
											<input type="text" name = "username" class="form-control">	
										</div>

										<div class="form-group">
											<span class="pull-right">
												<span class="checkbox">
													<label><input type="checkbox" name ="online"> Online now</label>
												</span>
											</span>
										</div>
										
									</div>
									<div class="col-sm-3">
										<button type = "submit" class="btn btn-success btn-block"> FIND WRITER</button>
									</div>
								</div>
							</form>

							<div class="row">
								<div class="col-sm-12">
									<p class="text-muted padding-t-30">Found {{ $writers->total() }} Writer(s)
									
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				@if(count($writers))

					@foreach($writers as $writer)	
						<div class="card-hover">
							<table class = "full-width table-responsive">
								<tr>
									<td></td>
									<td><img style = "max-width: 50px;height:auto" src="{{ empty($writer->image) ? asset('images/new-user.png') : asset('images/uploads/' . $writer->image) }}" class = "img-circle" style="margin:0 30px 0 10px;"></td>
									<td>
										<p>
											<span class = "theme-color">
												<strong><a href = "{{ route('getClientWriter', ['slug' => $writer->username]) }}">{{ $writer->username }}</a></strong>
											</span>  
											<span class = "text-muted"> 
												<small><i class="fa fa-circle"></i></small> {{ $writer->last_seen->diffForHumans() }}</span> 
										</p>
										<?php
											$language = $writer->my_languages()->first();
											$discipline = $writer->my_disciplines()->first();
											
											$discipline = $discipline ? $discipline->discipline : null;
											$discipline = $discipline ? $discipline->name : 'Other';

											$language = $language ? $language->language : null;
											$language = $language ? $language->name . ', ': 'Other, ';

											$ess = $language . $discipline;
										?>
										<p class = "text-black">{{ $ess }}</p>
										<p class = "text-muted">&nbsp;</p>
									</td>
									<td>
										<div class = "text-right">
											<?php
												if($count = count($writer->ratings)){
										            $stars = $writer->ratings()->sum('stars');
										            $stars = $stars / $count;
										        }else{
										            $stars = 0;
									        }?>
        									
											<p class = "text-warning">
												@if(round($stars,1) > 0)
													@for($count = 0; $count <= round($stars,1); $count++)
														<i class="fa fa-star text-warning"></i>
													@endfor
												@endif
											</p>

											<p class="theme-color"><strong><a href = "{{ route('getClientWriter', ['slug' => $writer->username]) }}" class = "btn btn-theme">Hire this writer</a></strong></p>
										</div>
										
									</td>
								</tr>
							</table>
						</div>
					@endforeach
				@else
					<div class="card">
						<h4>No writers found</h4>
					</div>
				@endif
				{{ $writers->links() }}
			</div>
			
		</div>
	</div>
@endsection
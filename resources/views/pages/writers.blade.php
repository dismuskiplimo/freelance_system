@extends('layouts.app')

@section('title', 'Writers')

@section('content')
	<div class="container-fluid">
	    <div class="row page-header">
	        <h2>{{ env('APP_NAME') }} — online academic exchange platform<br />
	            <small>Through us you can order an Essay, Term Paper, Dissertation, or other works!</small>
	        </h2>   
	    </div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2 fullscreen">
				

				<div class="row">
					<div class="col-sm-12">
						<h4>Writer Ratings</h4><br>
						<div class="">
							<form action="{{ route('getGuestSearchWriter') }}" method = "GET" >
								
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
							<a href = "{{ route('getGuestWriter', ['slug' => $writer->username]) }}">
							<table class = "full-width table-responsive">
								<tr>
									<td></td>
									<td><img style = "max-width: 50px;height:auto" src="{{ empty($writer->image) ? asset('images/new-user.png') : asset('images/uploads/' . $writer->image) }}" class = "img-circle" style="margin:0 30px 0 10px;"></td>
									<td>
										<p>
											<span class = "theme-color">
												<strong><a href = "{{ route('getGuestWriter', ['slug' => $writer->username]) }}">{{ $writer->username }}</strong>
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

										</div>
										
									</td>
								</tr>
							</table>
							</a>
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

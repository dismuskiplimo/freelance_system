@extends('layouts.app')

@section('title', 'Reviews')

@section('content')
	<div class="container-fluid">
	    <div class="row page-header">
	        <h2>{{ env('APP_NAME') }} — online academic exchange platform<br />
	            <small>Through us you can order an Essay, Term Paper, Dissertation, or other works!</small>
	        </h2>   
	    </div>
	</div>

	<div class="container fullscreen">
		<div class="row">
			<div class="col-lg-9">
					<h3>
						<a href="{{ route('getGuestWriter',['slug'=>$user->username]) }}">{{ $user->username }}</a> / reviews 
							<span class = "pull-right">
								<i class="fa fa-thumbs-up text-success"></i> 
								<span class="text-muted">Positive</span> 
								<span class="big-text text-bold">{{ count($user->ratings()->where('reaction', 'POSITIVE')->get()) }}</span>
								
								<i class="fa fa-thumbs-down text-danger"></i> 
								<span class="text-muted">Negative</span> 
								<span class="big-text text-bold">{{ count($user->ratings()->where('reaction', 'NEGATIVE')->get()) }}</span>
							</span> 
						</h3>

					<hr>
					
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
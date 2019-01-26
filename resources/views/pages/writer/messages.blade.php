@extends('layouts.writer')

@section('title', 'Messages')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12 fullscreen">
				<h4>Messages</h4><br>

				@if(count($conversations))
					@foreach($conversations as $conversation)
						<?php $message = $conversation->messages()->orderBy('created_at','DESC')->first(); ?>
								
						<a href="{{ route('getWriterConversation', ['id'=>$conversation->id]) }}">
							<div class="card {{ $message->read_status == 0 && $message->to_id == Auth::user()->id ? 'text-success' : '' }}">
								<div class="row">
									<div class="col-xs-1">
										<h4>
										@if($conversation->to_id == Auth::user()->id)
											<img src = "{{ $conversation->from->image ? asset('images/uploads' . '/' . $conversation->from->image) : asset('images/new-user.png') }}" class = "img-responsive img-circle" style = "width:60px" />
										@else
											<img src = "{{ $conversation->to->image ? asset('images/uploads' . '/' . $conversation->to->image) : asset('images/new-user.png') }}" class = "img-responsive img-circle" style = "width:60px" />
										@endif
										</h4>
									</div>

									<div class="col-xs-11">
										@if($conversation->to_id == Auth::user()->id)
											<h4><strong>{{ $conversation->from->username }}</strong></h4>
										@else
											<h4><strong>{{ $conversation->to->username }}</strong></h4>
										@endif
										
										
										@if($message)
											<p>
												{!! clean(Illuminate\Support\Str::words($message->message,30)) !!} <br>
												<small class = "pull-right text-muted">{{ $message->from_id == Auth::user()->id ? 'me' : $message->to->username }}, {{ $message->created_at->diffForHumans() }} {!! $message->read_status && $message->from_id == Auth::user()->id ? '<i class = "fa fa-check-circle theme-color"></i>' : '' !!}</small>	
											</p>
										@endif
									</div>
								</div>
										
							</div>	
						</a>
					@endforeach
				@else
					<div class="card">
						<h4>No messages for you</h4>
					</div>
				@endif
				
			</div>
		</div>
	</div>
@endsection
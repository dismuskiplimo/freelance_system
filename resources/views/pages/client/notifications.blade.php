@extends('layouts.client')

@section('title', 'Notifications')

@section('content')
	<div class="container fullscreen">
		<div class="row">
			<div class="col-xs-12">
				<h4>Notifications</h4> <br>
				@if(count(Auth::user()->notifications))
					@foreach(Auth::user()->notifications()->orderBy('created_at', 'DESC')->get() as $notification)
						<a href="{{ route('getClientNotification', ['id' => $notification->id]) }}">
							<div class="well{{ $notification->read_status == 0 ? ' text-info text-bold': ' text-black' }}">
								<strong>{{ $notification->author->username }}</strong> {{ $notification->message }} <br>
								<small>{{ $notification->created_at->diffForHumans() }}</small>
							</div>
						</a>
					@endforeach
				@endif
			</div>
		</div>
	</div>
@endsection
@extends('layouts.client')

@section('title', 'Conversation')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h4>{{ $recepient->username }}</h4> <br>

				@if(count($messages))
					<div class="card message-box">
						<div class="chat-box">
							@foreach($messages as $message)
								@if($message->from_id == Auth::user()->id && $message->to_id == $recepient->id)

									<div class="inner-grey margin-b-20">
										<div class="row">
											<div class = "col-xs-11 text-right">
												<p><strong>me</strong></p>
												<p>{!! clean($message->message) !!}</p>
												<small><span class = "pull-left">{{ $message->created_at->diffForHumans() }}</span></small>
											</div>	
											
											<div class="col-xs-1">
												<img class = "img-responsive img-circle" src="{{ empty(Auth::user()->image) ? asset('images/new-user.png') : asset('images/uploads/' . Auth::user()->image) }}" alt="{{ Auth::user()->username }}">
											</div>

										</div>	
									</div>
								@elseif($message->from_id == $recepient->id && $message->to_id == Auth::user()->id)
									<div class="inner-grey margin-b-20" style = "background-color: rgba(0,0,255,0.1)">
										<div class="row">
											<div class="col-xs-1">
												<img class = "img-responsive img-circle" src="{{ empty($recepient->image) ? asset('images/new-user.png') : asset('images/uploads/' . $recepient->image) }}" alt="{{ $recepient->username }}">
											</div>

											<div class = "col-xs-11">
												<p><strong style = "margin-right:15px">{{ $recepient->name }}</strong></p>
												<p>{!! clean($message->message) !!}</p>
												<small><span class = "pull-right">{{ $message->created_at->diffForHumans() }}</span></small>
											</div>	
										</div>	
									</div>
								@endif
							@endforeach	
						</div>
						
					</div>
					
				@else
					<div class="card">
						<h4>No messages between you and {{ $recepient->username }}</h4>
					</div>
				@endif
				
				<form action="{{ route('postClientMessage', ['id' => $recepient->id]) }}" method = "POST" enctype = "multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
						<textarea name="message" id="" rows="5" class="form-control" placeholder = "message">{{ old('message') }}</textarea>
					</div>
					<div class="form-group">
						<p>
							<input type="file" class="hidden" name = "attachment">
							<button type = "button" class="btn btn-info click-buddy"><i class="fa fa-paperclip"></i> Attach file</button> (Allowed filetypes: doc, docx, txt, pdf, jpg,png)
						</p>
						<p>
							<button type = "submit" class="btn btn-success">Send message</button>
							<a href="" data-toggle = "modal" data-target="#hire-modal" class="btn btn-warning pull-right">HIRE WRITER</a>
						</p>
					</div>
				</form>

			</div>
		</div>
	</div>

	<div class="modal fade" id = "hire-modal">
		<div class="modal-dialog">
			<form action="{{ route('postHireWriter', ['writer_id'=>$recepient->id]) }}" method = "POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Hire {{ $recepient->username }}</h4>
					</div>

					<div class="modal-body">
						<div class="form-group">
							<label for="">Assignment</label>
							<select name="assignment_id" id="" class="form-control" required >
								<option value="">-- Select assignment -- </option>
								@if(count($assignments))
									@foreach($assignments as $assignment)
										<option value="{{ $assignment->id }}">{{ $assignment->title }} ({{ $assignment->price == null || empty($assignment->price) ? 'negotiable' : '$' . number_format($assignment->price,2) }})</option>
									@endforeach
								@endif
							</select>
						</div>

						<div class="form-group">
							
							

							<input type="hidden" id = "commission-percent" value = "{{ $commission }}" />
							<input type="hidden" id = "conversation-url" value = "{{ url(route('getUserConversation',['id'=>$conversation->id])) }}" />
						</div>
					</div>

					<div class="modal-footer">

						<p>
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary pull-right">Hire writer</button>
						</p>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
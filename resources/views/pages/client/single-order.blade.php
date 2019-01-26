@extends('layouts.client')

@section('title', $assignment->title)

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3>{{ $assignment->title }}</h3><br>
				<div class="card">
					<h4>Assignment details</h4>
					@if($assignment->status == 'COMPLETE')
						<h4 class = "text-success">Completed by <b><a href = "{{ route('getClientWriter', ['slug' => $assignment->writer->username]) }}">{{ $assignment->writer->username }}</a></b>, {{ $assignment->completed_at->diffForHumans() }}</h4><br>
					@elseif($assignment->status == "PROGRESS")
						<h4 class = "text-success"><b><a href = "{{ route('getClientWriter', ['slug' => $assignment->writer->username]) }}">{{ $assignment->writer->username }}</a></b> <small class="text-muted">{{ $assignment->assigned_at->diffForHumans() }}</small>, is working on it</h4><br>
					@else
						<br>
					@endif
					<div class="row">
						<div class="col-md-6">
							<table class="table table-striped">
								
								<tr>
									<td>Price</td>
									<th>{{ $assignment->price == null || empty($assignment->price) ? 'negotiable' : '$' . number_format($assignment->price) }}</th>
								</tr>

								<tr>
									<td>Deadline</td>
									<th>{{ $assignment->deadline->diffForHumans() }}</th>
								</tr>

								<tr>
									<td>Volume</td>
									<th>{{ $assignment->pages }} pages ({{ number_format(250 * $assignment->pages) }} words)</th>
								</tr>
								
							</table>
						</div>
						<div class="col-md-6">
							<table class="table table-striped">
								
								<tr>
									<td>Discipline</td>
									<th>{{ $assignment->discipline ? $assignment->discipline->name : 'Others' }}</th>
								</tr>

								<tr>
									<td>Assignment type</td>
									<th>{{ $assignment->assignment_type->name }}</th>
								</tr>

								<tr>
									<td>Assignment ID</td>
									<th># {{ $assignment->id }}</th>
								</tr>
								
							</table>
						</div>

					</div>

					<hr>

					<div class="row padding-t-20">
						<div class="col-md-6">
							<table class="table table-striped">
								
								<tr>
									<td>Added</td>
									<th>{{ $assignment->created_at->diffForHumans() }}</th>
								</tr>

								<tr>
									<td>Type of service</td>
									<th>{{ $assignment->type_of_service }}</th>
								</tr>

							</table>
						</div>

						<div class="col-md-6">
							<table class="table table-striped">
								
								<tr>
									<td>Academic level</td>
									<th>{{ $assignment->academic_level->name }}</th>
								</tr>

								<tr>
									<td>Format</td>
									<th>{{ $assignment->format->name }}</th>
								</tr>

							</table>
						</div>

					</div>

					<div class="row">
						<div class="col-md-12">
							<p><strong>Description</strong></p>
							<p>{!! clean(nl2br($assignment->instructions)) !!}</p>
							<hr>
							
							<p><strong>Attachments</strong></p>

							@if(count($assignment->attachments))
								@foreach($assignment->attachments()->orderBy('created_at','DESC')->get() as $attachment)
									<p>
										
										<form action="{{ route('destroyAttachment', ['id'=>$attachment->id]) }}" class = "form-inline" method="post">
											{{ csrf_field() }}
											<input type="hidden" value = "DELETE" name = "_method">
											<a href="{{ route('getDownload', ['id'=>$attachment->id]) }}">{{ $attachment->filename }}</a> 
											
											@if($assignment->status != 'COMPLETE')
												<button type = "submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
											@endif
										</form>
										
									</p>
								@endforeach

							@else
								<p>No Attachments</p>
							@endif

							@if($assignment->status != 'COMPLETE' && $assignment->user->id == Auth::user()->id)
								<br><p>
									<form action="{{ route('postAddAttachment', ['id'=>$assignment->id]) }}" id = "image-form" method = "POST" enctype = "multipart/form-data">
										{{ csrf_field() }}
										<div class="form-group">
											<input type="file" name = "attachment" class = "hidden auto-submit">
											<button type = "button" class = "btn btn-info click-buddy"><i class="fa fa-paperclip"></i> ADD ATTACHMENT</button>
										</div>
									</form>
								</p>
							@endif
							<hr>
							

							
							<p><strong>Completed Assignments Uploaded by writer</strong></p>

							@if($assignment->attachments()->where('section', 'WRITER')->count())
								@foreach($assignment->attachments()->where('section', 'WRITER')->orderBy('created_at','DESC')->get() as $attachment)
									<p>
										<a href="{{ route('getDownload', ['id'=>$attachment->id]) }}">{{ $attachment->created_at }} - {{ $attachment->filename }}</a> 
									</p>
								@endforeach
								<hr>
							@else
								<p>No Assignment Uploaded by Writer</p>
							@endif

							
							
							<div class="row">
								<div class="col-sm-6">
									
								</div>

								<div class="col-sm-6">
									@if($assignment->status == 'PROGRESS' && $assignment->user->id == Auth::user()->id)
										<p>
											<form action="{{ route('postMarkComplete', ['id'=> $assignment->id]) }}" method = "POST">
												{{ csrf_field() }}
												<div class="form-group">
													<button type = "submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Mark assignment as complete</button>
												</div>
											</form>
										</p>
									@endif

									@if($assignment->status == "AUCTION")
										<a href="" data-toggle="modal" data-target="#extend-deadline-modal" class="btn btn-primary pull-right"><i class="fa fa-clock-o"></i> Extend deadline</a>

										<div class="modal fade" id = "extend-deadline-modal">
											<div class="modal-dialog modal-sm">
												<div class="modal-content">
													<form action="{{ route('postUpdateDeadline',['id'=>$assignment->id]) }}" method = "POST">
														{{ csrf_field() }}
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title">Extend deadline</h4>
														</div>
														<div class="modal-body">
															
															<div class="form-group">
																<label for="">New deadline</label>
																<input type="text" name = "deadline" class="form-control deadline" required />
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Extend deadline</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									@endif
								</div>

								
							</div>
						</div>
					</div>
				</div>

			</div>	
			
		</div>

		<div class="row">
			<div class="col-md-12">
				<h4>Offers from Writers ({{ $assignment->bids }})</h4><br>

				@if($assignment->bids)
					@foreach($assignment->bids_placed as $bid)
						<div class="card">
							<table class="full-width">
								<tr>
									<td>
										<div class = "pull-left" style = "margin-right:10px">
											<img src="{{ empty($bid->user->thumbnail) ? asset('images/new-user-thumbnail.png') : asset('images/uploads/' . $bid->user->thumbnail)  }}" style = "margin-top:5px" alt="{{ $bid->user->name }}">
										</div>
										<div class = "pull-left">
											<p>
												<strong>
													<a href="{{ route('getClientWriter',['slug'=>$bid->user->username]) }}"> {{ $bid->user->username }}</a> 
												</strong>
												<small><small><i class="fa fa-circle text-success"></i> {{ $bid->user->last_seen->diffForHumans() }} </small></small>
												
											</p>

											<?php
												if($count = count($bid->user->ratings)){
										            $stars = $bid->user->ratings()->sum('stars');
										            $stars = $stars / $count;
										        }else{
										            $stars = 0;
									        }?>
        									
											<p class = "text-warning">
												@if(round($stars,1) > 0)
													@for($count = 0; $count < round($stars,1); $count++)
														<i class="fa fa-star text-warning"></i>
													@endfor
												<span class="theme-color">{{ number_format(round($stars,1),2) }}</span>
												@endif
											</p>
										</div>
										
									</td>
									<td><i class="fa fa-certificate text-warning big-size"></i></td>
									<td>Writers offer: <span class="text-black text-bold">{{ empty($bid->amount) || is_null($bid->amount) ? 'negotiable' : '$' . number_format($bid->amount,2) }}</span></td>
									<td>
										@if($assignment->status == 'AUCTION')
											@if(empty($bid->amount) || is_null($bid->amount))
												<a href="" data-toggle="modal" data-target="#modal-with-price-{{ $bid->user->id }}" class="btn btn-success pull-right">HIRE THIS WRITER</a>
											@else
												<a href="" data-toggle="modal" data-target="#modal-without-price-{{ $bid->user->id }}" class="btn btn-success pull-right">HIRE THIS WRITER</a>
											@endif
										@endif
									</td>
									
								</tr>
							</table>

							<p>{{ $bid->comment }}</p>						
							
							<div class="faint-grey-full">
								
								<table class = "full-width">
									<tr>
										<td>Total orders completed <strong>({{ number_format($bid->user->orders_complete) }})</strong></td>
										
										<td>
											<span class = "text-success text-bold"><i class="fa fa-thumbs-up"></i> {{ count($bid->user->ratings()->where('reaction','POSITIVE')->get()) }}</span> 
											
										</td>

										<td><span class = "text-danger text-bold"><i class="fa fa-thumbs-down"></i> {{ count($bid->user->ratings()->where('reaction','NEGATIVE')->get()) }}</span></td>
										
										<td><a href="" data-toggle = "modal" data-target = "#bid-{{ $bid->id }}" class="btn btn-info pull-right">Comments ({{ count($bid->comments) }})</td>
									</tr>
								</table>
							</div>

							<div class="modal fade" id = "bid-{{ $bid->id }}">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title">Comments ({{ count($bid->comments) }})</h4>
										</div>
										<form action="{{ route('postClientComment', ['id'=>$bid->id]) }}" method = "POST">
										<div class="modal-body">
											<div class="row">
												<input type="hidden" name = "bid_id" value = "{{ $bid->id }}">
												<div class="col-xs-12">
													<div class="comments-wrapper">
														<div class="comments">
															@if(count($bid->comments))
																@foreach($bid->comments()->orderBy('created_at', 'ASC')->get() as $comment)
																	<div class="well">
																		<p><strong>{{ $comment->user->username }}</strong></p>
																		<p>{{ $comment->message }}</p>
																		<p class = "text-right"><small>{{ $comment->created_at->diffForHumans() }}</small></p>
																	</div>
																@endforeach
															@else
																<p>No comments</p>
															@endif
														</div>
													</div>
												</div>

												<div class="col-xs-12">
													<div class="comment">
														<div class="form-group">
															{{ csrf_field() }}
															<label for="">Comment</label>
															<textarea name = "message" rows="3" class = "form-control"></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary">Comment</button>
										</div>

										</form>
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->


						</div>
						
						@if(empty($bid->amount) || is_null($bid->amount))
							<div class="modal fade" id = "modal-with-price-{{ $bid->user->id }}">
								<div class="modal-dialog">
									<form action="{{ route('postHireWriter', ['writer_id'=>$bid->user->id]) }}" method = "POST">
										{{ csrf_field() }}
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">Hire {{ $bid->user->username }} ?</h4>
											</div>

											<div class="modal-body">

												<div class="form-group">
													
													<div class="row">
														<div class="col-md-7">
															<label for="">Custom price</label>
															<div class="input-group">
																<span class="input-group-addon">$</span>
																<input type="number" min = "4" name = "amount" class="form-control" id = "money-input" placeholder = "$4 minimum" required />
															</div>
														</div>
														<div class="col-md-5">
															<label for="">Amount payable</label>
															<h4><span id = "money-span"></span></h4>
														</div>
													</div>
													
													<input type="hidden" value = "{{ $assignment->id }}" name = "assignment_id">
													<input type="hidden" id = "commission-percent" value = "{{ $commission }}" />
													
												</div>
											</div>

											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
												<button type="submit" class="btn btn-primary pull-right">Hire writer</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						@else
							<div class="modal fade" id = "modal-without-price-{{ $bid->user->id }}">
								<div class="modal-dialog">
									<form action="{{ route('postHireWriter', ['writer_id'=>$bid->user->id]) }}" method = "POST">
										{{ csrf_field() }}
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">Hire {{ $bid->user->username }} ?</h4>
											</div>

											<div class="modal-body">
												<?php $commission = App\Settings::where('name', 'commission_percent')->first(); $commission = $commission->value; ?>
												<h4 class="text-center">
													Hire <strong>{{ $bid->user->username }}</strong> for 
													<strong>$ {{ number_format($bid->amount,2) }}</h4>
												<div class="form-group">
													
													<input type="hidden" value = "{{ $assignment->id }}" name = "assignment_id">
													<input type="hidden" value = "{{ $bid->amount }}" name = "amount">
												</div>

											</div>

											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
												<button type="submit" class="btn btn-primary pull-right">Hire writer</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						@endif

					@endforeach
				@endif

			</div>
		</div>
	</div>
@endsection
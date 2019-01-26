@extends('layouts.writer')

@section('title', $assignment->title)

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3>{{ $assignment->title }}{!! $assignment->status == 'COMPLETE' ? ' <span class="text-success">(COMPLETE)</span>' : '' !!}</h3><br>
				<div class="card">
					@if($assignment->status == 'COMPLETE')
						<h4>Completed by <a href = "{{ route('getUserProfile',['slug'=>$assignment->writer->username]) }}">{{ $assignment->writer->username }}</a></h4><br />
					@endif
					<div class="row">
						<div class="col-lg-12">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#assignment-description" aria-controls="assignment-description" role="tab" data-toggle="tab">Description</a></li>
								<li role="presentation"><a href="#assignment-details" aria-controls="assignment-details" role="tab" data-toggle="tab">Details</a></li>
							</ul>
						</div>
						
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="assignment-description">
								<div class="col-md-6">
									<table class="table table-striped">
										
										<tr>
											<td>Deadline</td>
											<th class = "text-danger">{{ $assignment->deadline->diffForHumans() }}</th>
										</tr>

										<tr>
											<td>Price</td>
											<th>{{ empty($assignment->price) || is_null($assignment->price) ? 'negotiable' : '$' . number_format($assignment->price) }}</th>
										</tr>

										<tr>
											<td>Discipline</td>
											<th>{{ $assignment->discipline ? $assignment->discipline->name : 'Others' }}</th>
										</tr>

										<tr>
											<td>Assignment type</td>
											<th>{{ $assignment->assignment_type ? $assignment->assignment_type->name : 'Others' }}</th>
										</tr>				
										
									</table>
								</div>
								<div class="col-md-6">
									<table class="table table-striped">
										
										
										<tr>
											<td>
												<img style = "width:auto;height:60px;" src="{{ $assignment->user->image ? asset('images/uploads/'. $assignment->user->image) : asset('images/new-user.png')}}" alt="{{ $assignment->user->username }}">
											</td>
											<td>
												<p><strong>{{ $assignment->user->username }},</strong> last seen {{ $assignment->user->last_seen->diffForHumans() }}</p>
												<p style="margin-bottom:5px"><small>Assignment added {{ $assignment->created_at->diffForHumans() }} </small></p>
											</td>
										</tr>
										

										<tr>
											<td>Assignment ID</td>
											<th># {{ $assignment->id }}</th>
										</tr>

										<tr>
											<td>Stage of completion</td>
											@if($assignment->status == "AUCTION")
												<th class = "text-info">{{ $assignment->status }}</th>
											@elseif($assignment->status == "PROGRESS")
												<th class = "text-warning">{{ $assignment->status }}</th>
											@elseif($assignment->status == "COMPLETE")
												<th class = "text-success">{{ $assignment->status }}</th>
											@else
												<th class = "text-primary">{{ $assignment->status }}</th>
											@endif
											
										</tr>
										
									</table>
								</div>
							</div>

							<div role="tabpanel" class="tab-pane" id="assignment-details">
								<div class="row padding-t-20">
									<div class="col-md-6">
										<table class="table table-striped">
											<tr>
												<td>Format</td>
												<th>{{ $assignment->format->name }}</th>
											</tr>
											
											<tr>
												<td>Academic level</td>
												<th>{{ $assignment->academic_level->name }}</th>
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
												<td>Type of service</td>
												<th>{{ $assignment->type_of_service }}</th>
											</tr>

									
										</table>
									</div>

								</div>
							</div>
						</div>
						
					</div>

					<hr>

					<div class="row">
						<div class="col-md-12">
							<p><strong>Description</strong></p>
							<p>{!! clean(nl2br($assignment->instructions)) !!}</p><br>

							@if($assignment->attachments()->where('section', NULL)->count())
								<p><strong>Attachments</strong></p>
								@foreach($assignment->attachments()->where('section', NULL)->orderBy('created_at','DESC')->get() as $attachment)
									<p>
										<a href="{{ route('getDownload', ['id'=>$attachment->id]) }}">{{ $attachment->filename }}</a> 
									</p>
								@endforeach
								<hr>
							@endif

							@if($assignment->writer_id == Auth::user()->id)
								<p><strong>Completed Assignments</strong></p>

								@if($assignment->attachments()->where('section', 'WRITER')->count())
									@foreach($assignment->attachments()->where('section', 'WRITER')->orderBy('created_at','DESC')->get() as $attachment)
										

										<p>
										
											<form action="{{ route('destroyAttachmentWriter', ['id'=>$attachment->id]) }}" class = "form-inline" method="post">
												{{ csrf_field() }}
												<input type="hidden" value = "DELETE" name = "_method">
												<a href="{{ route('getDownload', ['id'=>$attachment->id]) }}">{{ $attachment->created_at }} - {{ $attachment->filename }}</a> 

												@if($assignment->status != 'COMPLETE')
													<button type = "submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
												@endif
											</form>
											
										</p>
									@endforeach

									

									<hr>
								@else
									<p>No Assignment Uploaded</p>
								@endif

								@if($assignment->status != 'COMPLETE')

									<form action="{{ route('postAddAttachmentWriter', ['id'=> $assignment->id]) }}" method="POST" id="image-form" enctype="multipart/form-data">
										{{ csrf_field() }}

										<input type="hidden" name="section" value="WRITER">

										<div class="form-group">
											<input type="file" name="attachment" class="hidden auto-submit">
											<button type="button" class="btn btn-info click-buddy"><i class="fa fa-paperclip"></i> UPLOAD COMPLETED ASSIGNMENT</button>
										</div>
									</form>

								@endif
							@endif
							
							@if($assignment->status == "AUCTION")
								@if(count($my_bid))
									@if(is_null($my_bid->amount) || empty($my_bid->amount))
										<button type = "button" data-toggle="modal" data-target="#bid-modal" class="btn btn-success">UPDATE BID</button>
									@endif
								@else
									<button type = "button" data-toggle="modal" data-target="#bid-modal" class="btn btn-success">PLACE A BID</button>
								@endif
							@endif
						</div>
					</div>
				</div>

			</div>	
			
		</div>

		<div class="row">
			<div class="col-md-12">
				<h4>Offers from Writers ({{ $assignment->bids }})</h4><br>

				@if($assignment->bids)
					@foreach($assignment->bids_placed as $bid )
						<div class="card">
							<table class="full-width">
								<tr>
									<td>
										<div class = "pull-left" style = "margin-right:10px">
											<img src="{{ $bid->user->thumbnail ? asset('images/uploads/' . $bid->user->thumbnail) : asset('images/new-user-thumbnail.png') }}" style = "margin-top:5px" alt="{{ $bid->user->username }}">
										</div>
										<div class = "pull-left">
											<p>
												<strong>
													<a href="{{ route('getUserProfile',['slug'=> $bid->user->username]) }}">{{ $bid->user->username }}</a> 
												</strong>
												<small><small><i class="fa fa-circle text-success"></i> {{ $bid->updated_at }}</small></small>
												
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
									<td></td>
									<td></td>
									<td><span class="btn btn-success pull-right">{{ is_null($bid->amount) || empty($bid->amount) ? 'NO BID PLACED' : '$' . number_format($bid->amount,2) }}</a></td>
									
								</tr>
							</table>

							<p>{{ $bid->comment }}</p>						
							
							<div class="faint-grey-full">
								
								<table class = "full-width">
									<tr>
										<td>Total orders completed <strong>({{ count($bid->user->orders_assigned()->where('status','COMPLETE')->get()) }})</strong></td>
										
										<td>
											<span class = "text-success text-bold"><i class="fa fa-thumbs-up"></i> {{ count($bid->user->ratings()->where('reaction','POSITIVE')->get()) }}</span> 
											
										</td>

										<td><span class = "text-danger text-bold"><i class="fa fa-thumbs-down"></i> {{ count($bid->user->ratings()->where('reaction','NEGATIVE')->get()) }}</span></td>
										
										<td><a href="" data-toggle = "modal" data-target = "#bid-{{ $bid->id }}" class="btn btn-info pull-right">Comments ({{ count($bid->comments) }})</a></td>
									</tr>
								</table>
							</div>
						</div>

						<div class="modal fade" id = "bid-{{ $bid->id }}">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Comments ({{ count($bid->comments) }})</h4>
									</div>
									<form action="{{ route('postWriterComment', ['id'=>$bid->id]) }}" method = "POST">
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
					@endforeach

				@endif

				
			</div>
		</div>
	</div>
	@if($assignment->status == "AUCTION")
		@if(count($my_bid))
			@if(is_null($my_bid->amount) || empty($my_bid->amount))
				<div class="modal fade" id = "bid-modal">
					<div class="modal-dialog">
						<div class="modal-content">
							<form action="{{ route('postBid', ['id' => $assignment->id]) }}" method = "post">
								{{ csrf_field() }}
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">UPDATE BID</h4>
								</div>
								<div class="modal-body">
									
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="">My Offer</label>
												<div class="input-group">
													<span class="input-group-addon">$</span>
													<input type="number" min="5" name = "amount" class = "form-control" />
												</div>
												
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="">Amount to be paid by student</label>
												<h3 style = "margin-top:5px">$ 0</h3>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-12">
											<label for="">Comment</label>
											<textarea name="comment" id="" rows="10" class="form-control" required>{{ $my_bid->comment }}</textarea>
										</div>
									</div>
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="submit" class="btn btn-primary">UPDATE BID</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			@endif
		@else
			<div class="modal fade" id = "bid-modal">
				<div class="modal-dialog">
					<div class="modal-content">
						<form action="{{ route('postBid', ['id' => $assignment->id]) }}" method = "post">
							{{ csrf_field() }}
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">PLACE A BID</h4>
							</div>
							<div class="modal-body">
								
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<?php $percent = App\Settings::where('name','commission_percent')->first(); ?>
											<input type="hidden" id = "commission-percent" value = "{{ $percent->value }}">
											<label for="">My Offer</label>
											<div class="input-group">
												<span class="input-group-addon">$</span>
												<input type="number" min="5" id = "money-input-1" name = "amount" class = "form-control" />
											</div>
											
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">You will receive</label>
											<h3 style = "margin-top:5px"><span id = "money-span-1">$ 0</span></h3>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<label for="">Comment</label>
										<textarea name="comment" id="" rows="10" class="form-control" required></textarea>
									</div>
								</div>
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-primary">PLACE BID</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		@endif
	@endif
@endsection
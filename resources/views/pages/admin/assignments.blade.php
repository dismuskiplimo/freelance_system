@extends('layouts.admin')

@section('title', 'Assignments')

@section('content')

@include('includes.admin.assignments-nav')

@if(count($assignments))
<div class="row">
	<div class="col-lg-xs-12">
		<div class="card">
			
			<div class="content">
				
					<table class="table table-responsive table-striped">
						<thead>
							<tr>
								<th>Assignment</th>
								<th>Type</th>
								<th>Discipline</th>
								<th>Pages</th>
								<th>Deadline</th>

								@if($type == "complete" || $type == "late")
									<th>Completed at</th>
								@endif

								@if($type == "rejected")
									<th>Rejected at</th>
								@endif

								<th>Type of service</th>
								<th>Client</th>
								@if($type == "progress" || $type == "complete" || $type == "rejected" || $type == "late")
									<th>Writer</th>
								@endif
								<th>Price</th>
							</tr>
						</thead>

						<tbody>
							@foreach($assignments as $assignment)
							<tr>
								<td>
									<a href="" data-toggle = "modal" data-target = "#assignment-{{ $assignment->id }}">{{ $assignment->title }}</a>
									<div class="modal fade" id = "assignment-{{ $assignment->id }}">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title">{{ $assignment->title }}</h4>
												</div>
												<div class="modal-body">
													@if($assignment->status == 'COMPLETE')
														<h4>Completed by <a href = "{{ route('getAdminUser',['slug'=>$assignment->writer->id]) }}">{{ $assignment->writer->username }}</a></h4><br />
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
																			
																				@if($assignment->user)
																					<td>
																						<img style = "width:auto;height:60px;" src="{{ $assignment->user->image ? asset('images/uploads/'. $assignment->user->image) : asset('images/new-user.png')}}" alt="{{ $assignment->user->username }}">
																					</td>
																					<td>
																						<p><strong>{{ $assignment->user->username }},</strong> last seen {{ $assignment->user->last_seen }}</p>
																						<p style="margin-bottom:5px"><small>Assignment added {{ $assignment->created_at }} </small></p>
																					</td>
																				@else
																					<td>
																						<img style = "width:auto;height:60px;" src="{{ asset('images/new-user.png')}}">
																					</td>
																					<td>
																						
																						<p style="margin-bottom:5px"><small>Assignment added {{ $assignment->created_at }} </small></p>
																					</td>
																				@endif
																				
																			
																			
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

															@if(count($assignment->attachments))
																<p><strong>Attachments</strong></p>
																@foreach($assignment->attachments()->orderBy('created_at','DESC')->get() as $attachment)
																	<p>
																		<a href="{{ route('getDownload', ['id'=>$attachment->id]) }}">{{ $attachment->filename }}</a> 
																	</p>
																@endforeach
																<hr>
															@endif
															
														</div>
													</div>
															
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												</div>
											</div>
											
										</div>
									</div>	
								</td>
								<td><a href="" data-toggle = "modal" data-target = "#assignment-{{ $assignment->id }}">{{ $assignment->assignment_type ? $assignment->assignment_type->name : 'Other' }}</a></td>
								<td><a href="" data-toggle = "modal" data-target = "#assignment-{{ $assignment->id }}">{{ $assignment->discipline ? $assignment->discipline->name : 'Other' }}</a></td>
								<td>{{ number_format($assignment->pages) }}</td>
								<td>{{ $assignment->deadline }}</td>
								@if($type == "complete" || $type == "late")
									<td>{{ $assignment->completed_at }}</td>
								@endif

								@if($type == "rejected")
									<td>{{ $assignment->rejected_at }}</td>
								@endif


								<td>{{ $assignment->type_of_service }}</td>
								<td>
									@if($assignment->user)
										<a href="{{ route('getAdminUser',['id'=>$assignment->user->id]) }}">{{ $assignment->user->username }}</a>
									@else
										N/A
									@endif
									
								</td>
								@if($type == "progress" || $type == "complete" || $type == "rejected" || $type == "late")
									<td><a href="{{ route('getAdminUser',['id'=>$assignment->writer->id]) }}">{{ $assignment->writer ? $assignment->writer->username : 'N/A' }}</a></td>
								@endif
								<td>{{ $assignment->price == null || empty($assignment->price) ? 'negotiable' : '$' . number_format($assignment->price,2) }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>

					{{ $assignments->links() }}
				
			</div>
		</div>
	</div>
</div>

@endif
    
@endsection
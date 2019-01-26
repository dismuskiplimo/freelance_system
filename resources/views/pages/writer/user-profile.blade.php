@extends('layouts.writer')

@section('title', $user->name)

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				@include('includes.writer.sidebar-profile')
			</div>
			<div class="col-md-6">
				<div class="card">
					<h4>{{ $user->username }} 
						<small>
							<i class="fa fa-circle"></i>
							<span class = "text-muted">{{ $user->last_seen->diffForHumans() }}</span>
						</small>

						<span class="pull-right">
							@if(round($stars,1) > 0)
								@for($count = 0; $count <= round($stars,1); $count++)
									<i class="fa fa-star text-warning"></i>
								@endfor
							{{ number_format(round($stars,1),2) }}
							@endif
							

						</span>
					</h4>

					<hr>

					<p><strong>About me</strong></p>
					<p>{{ $user->about }}</p><br />
					
					<p><strong>Education</strong></p>
					<p>
						{{ $user->school }}{{ $user->academic_level ? ', '. $user->academic_level->name : '' }}<br> 
						
						
						
					</p><br />

					<p><strong>Field of specialization</strong><br></p>
					<p>{{ $user->field_of_specialization }}</p><br>

					<p><strong>Languages</strong></p>
					<p>
						@if(count($user->my_languages))
							@foreach($user->my_languages as $language)
								{{ $language->language ? $language->language->name . ', ' : 'Other, ' }}
							@endforeach
						@else
							English
						@endif
					</p><br />
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="card">
							<table>
								<tr>
									<td><i class="fa fa-bookmark big-size" style = "margin-right:20px"></i></td>
									<td>
										Reviews<br />
										<span class="text-muted">Excellent</span>
									</td>
								</tr>
							</table>
							
							<div class="margin-tb-20 progress">
								<div class="progress-bar progress-bar-success" style = "width:{{ $positive_percent  }}%">
									<span class="sr-only">{{ $positive_percent  }}% Complete(success)</span>
								</div>

								<div class="progress-bar progress-bar-danger" style = "width:{{ $negative_percent }}%">
									<span class="sr-only">{{ $negative_percent }}% Complete(danger)</span>
								</div>			
							</div>
							<small><small>
								<table class="full-width">
									<tr>
										<td>
											<div class="col-xs-2">
												<i class="fa fa-thumbs-up medium-size text-success" style = "margin-right:10px"></i>
											</div>
											<div class="col-xs-10">
												{{ $positive_percent  }}% <span class="text-muted">({{ $positive_reviews }})</span> <br>
												<span class="text-muted">Positive</span>
											</div>
										</td>
										<td>
											<div class="col-xs-2">
												<i class="fa fa-thumbs-down medium-size text-danger" style = "margin-right:10px"></i>
											</div>
											<div class="col-xs-10">
												{{ $negative_percent }}% <span class="text-muted">({{ $negative_reviews }})</span> <br>
												<span class="text-muted">Negative</span>
											</div>
										</td>
									</tr>
								</table>
							</small></small>

						</div>
					</div>
					<div class="col-md-6">
						<div class="card">

							<table>
								<tr>
									<td><i class="fa fa-bookmark big-size" style = "margin-right:20px"></i></td>
									<td>
										Deadlines<br />
										<span class="text-muted">Delivers on time</span>
									</td>
								</tr>
							</table>

							<div class="margin-tb-20 progress">
								<div class="progress-bar progress-bar-success" style = "width:{{ $on_time_percent }}%">
									<span class="sr-only">{{ $on_time_percent }}% Complete(success)</span>
								</div>

								<div class="progress-bar progress-bar-danger" style = "width:{{ $late_percent }}%">
									<span class="sr-only">{{ $late_percent }}% Complete(danger)</span>
								</div>			
							</div>
							<small><small>
								<table class="full-width">
									<tr>
										<td>
											<div class="col-xs-2">
												<i class="fa fa-clock-o medium-size text-success" style = "margin-right:10px"></i>
											</div>
											<div class="col-xs-10">
												{{ $on_time_percent }}% <span class="text-muted">({{ $on_time }})</span> <br>
												<span class="text-muted">On Time</span>
											</div>
										</td>
										<td>
											<div class="col-xs-2">
												<i class="fa fa-clock-o medium-size text-danger" style = "margin-right:10px"></i>
											</div>
											<div class="col-xs-10">
												{{ $late_percent }}% <span class="text-muted">({{ $late }})</span> <br>
												<span class="text-muted">Delayed</span>
											</div>
										</td>
									</tr>
								</table>
							</small></small>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews ({{ number_format(count($user->ratings)) }})</a></li>
								<li role="presentation"><a href="#finished" aria-controls="finished" role="tab" data-toggle="tab">Finished Assignments ({{ number_format(count($user->orders_assigned()->where('status', 'COMPLETE')->get())) }})</a></li>
								<!--<li role="presentation"><a href="#statistics" aria-controls="statistics" role="tab" data-toggle="tab">Statistics</a></li>-->
								<li role="presentation"><a href="#portofolio" aria-controls="portofolio" role="tab" data-toggle="tab">Portfolio ({{ number_format(count($user->portfolio)) }})</a></li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content padding-tb-20">
								<div role="tabpanel" class="tab-pane active" id="reviews">
									
									@if(count($user->ratings))
										<p class="text-right"><a href="{{ route('getWriterReviews', ['slug'=>$user->username]) }}">See all reviews</a></p><br />

										<table class="table full-width">
											@foreach($user->ratings()->orderBy('created_at','DESC')->take(15)->get() as $rating)
												<tr>
													<td>
														<img src="{{ $rating->client->image ? asset('images/uploads/'. $rating->client->image) : asset('images/new-user.png') }}" style = "width:60px;" alt="">
													</td>
													<td>
														<p class = "theme-color"><strong>{{ $rating->client->username }}</strong></p>
														<p>{{ $rating->title }}</p>
													</td>
													<td>
														<span class="text-muted">{{ $rating->created_at->diffForHumans() }}</span>
													</td>
													<td>
														@if($rating->reaction == 'POSITIVE')
															<i class="fa fa-thumbs-up text-success" style = "margin-right:10px"></i> Positive
														@else
															<i class="fa fa-thumbs-down text-danger" style = "margin-right:10px"></i> Negative
														@endif
														
													</td>
													<td>
														@if($rating->assignment()->whereRaw('assignments.completed_at <= assignments.deadline')->first())
															<i class="fa fa-clock-o text-success" style = "margin-right:10px"></i> On Time
														@else
															<i class="fa fa-clock-o text-danger" style = "margin-right:10px"></i> Late
														@endif
														
													</td>
												</tr>
											@endforeach
										</table>
									@endif
								</div>
								<div role="tabpanel" class="tab-pane" id="finished">
									<p>&nbsp; </p>
									@if(count($user->orders_assigned()->where('status','COMPLETE')->take(15)->get()))
										<table class="table full-width">
											<thead>
												<tr>
													<td>ORDER</td>
													<td>REVIEW</td>
													<td>DEADLINE</td>
												</tr>
											</thead>

											<tbody>
												@foreach($user->orders_assigned()->where('status','COMPLETE')->orderBy('completed_at','DESC')->get() as $order_assigned)
												<tr>
													<td>
														<span class="text-muted">{{ $order_assigned->discipline ? $order_assigned->discipline->name : '' }}</span> <br>
														{{ $order_assigned->assignment_type ? $order_assigned->assignment_type->name : '' }}
													</td>
													<td>
														@if($order_assigned->rating)
															@if($order_assigned->rating->reaction == 'POSITIVE')
																<i class="fa fa-thumbs-up medium-size text-success"></i>
															@else
																<i class="fa fa-thumbs-down medium-size text-danger"></i>
															@endif
														@else
															NO REVIEW MADE
														@endif
													</td>
													<td>
														<?php $dead = new Carbon\Carbon($order_assigned->deadline); 
															  $compl = new Carbon\Carbon($order_assigned->completed_at);?>

														@if($compl->gt($dead))
															
														<i class="fa fa-clock-o medium-size text-danger"></i> Late
														@else
															<i class="fa fa-clock-o medium-size text-success"></i> On time
														@endif
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									@endif
								</div>
							
								<div role="tabpanel" class="tab-pane" id="portofolio">
									@if($user->id == Auth::user()->id)
										<p><button class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#add-portofolio-modal">ADD PORTFLOIO</button></p><br>
										
										<div class="modal fade" id = "add-portofolio-modal">
											<div class="modal-dialog">
												<form action="{{ route('postPortfolio') }}" method = "POST" enctype = "multipart/form-data">
													{{ csrf_field() }}
													<div class="modal-content">
														<div class="modal-header">
															<button class = "close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title">ADD PORTFOLIO</h4>
														</div>
														<div class="modal-body">
															<div class="form-group">
																<label for="">File</label>
																<input type="file" name = "file" >
															</div>
															<div class="form-group">
																<label for="">Information</label>
																<textarea name="information" id="" rows="3" class="form-control"></textarea>
															</div>
														</div>
														<div class="modal-footer">
															<button class = "btn btn-default pull-left" data-dismiss="modal">Close</button>
															<button class = "btn btn-info pull-right" type = "submit">Add portfolio</button>
														</div>
														
													</div>
												</form>
												
											</div>
										</div>

										@if(count($user->portfolio))
											<br>
											@foreach($user->portfolio as $portfolio)
												<p><a href="{{ route('getPortfolio', ['id'=>$portfolio->id]) }}" ><i class="fa fa-download medium-size"></i> {{ $portfolio->filename }}</a> <a href="{{ route('deletePortfolio',['id'=>$portfolio->id]) }}" title = "delete portfolio"><i class="fa fa-times pull-right text-danger"></i></a></p>
											@endforeach
										@endif
										
										
									@else
										@foreach($user->portfolio as $portfolio)
											<p><a href="{{ route('getPortfolio', ['id'=>$portfolio->id]) }}" class = "btn-block"> {{ $portfolio->filename }} <i class="fa fa-download medium-size"></i></a></p>
										@endforeach
									@endif
								</div>
							</div>

						</div>
					</div>

					
				</div>
			</div>

			<div class="col-md-3">
				@include('includes.writer.sidebar-assignments')
			</div>
		</div>
	</div>
@endsection
@extends('layouts.writer')

@section('title', 'Assignments')

@section('content')
	<div class="container">
		<div class="row fullscreen">
			<div class="col-xs-12">
				<h4 class = "mergin-tb-20">Assignment search</h4>
				<div class="card">
					<p><strong>Search for new order <span class="text-muted">Found {{ count($assignments) }} orders</span></strong></p>

					<form action="{{ route('getOrderSearchFilter') }}" method = "GET">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-9">
									<div class="form-group">
										<input type="text" name = "name" value = "{{ $request->has('name') ? $request->name : '' }}" placeholder = "assignment name" class="form-control">
									</div>
								</div>
								<div class="col-xs-3">
									<div class="form-group"><button class="btn btn-block btn-primary" type = "submit"><i class="fa fa-search"></i></button></div>

								</div>
							</div>

							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<select name="discipline_id" placeholder = "discipline" class = "form-control" id="">
											<option value="0"> -- All disciplines --</option>
											@foreach($disciplines as $discipline)
												@if($request->has('discipline_id'))
													<option value="{{ $discipline->id }}"{{ $request->discipline_id == $discipline->id ? 'selected' : '' }}>{{ $discipline->name }}</option>
												@else
													<option value="{{ $discipline->id }}">{{ $discipline->name }}</option>
												@endif
												
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<select name="academic_level_id" id="" class = "form-control">
											<option value="0"> -- All academic levels --</option>
											@foreach($academic_levels as $academic_level)
												@if($request->has('academic_level_id'))
													<option value="{{ $academic_level->id }}"{{ $request->academic_level_id == $academic_level->id ? 'selected' : '' }}>{{ $academic_level->name }}</option>
												@else
													<option value="{{ $academic_level->id }}">{{ $academic_level->name }}</option>
												@endif
												
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<div class="checkbox">
											<label for="">
												<input type="checkbox" {{ $request->has('bids') ? 'checked="checked"' : '' }}name = "bids"> Assignment without bids
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>

				@if(count($assignments))
					<h4>Assignments</h4>
					@foreach($assignments as $assignment)
						<div class="card">
							<table class="full-width">
								
								<tr class = "text-bold">
									<td><i class="fa fa-envelope theme-color medium-size"></i></td>
									<td colspan="5"><a href="{{ route('getSingleWriterOrder', ['id'=>$assignment->id]) }}">{{ $assignment->title }}</a></td>
								</tr>

								<tr class = "text-itallic">
									<td></td>
									<td></td>
									<td>Posted</td>
									<td>Deadline</td>
									<td>Bids</td>
									<td>Price</td>
								</tr>
								<tr class = "text-bold">
									<td></td>
									<td>{{ $assignment->assignment_type ? $assignment->assignment_type->name : '' }}, {{ $assignment->discipline ? $assignment->discipline->name : '' }}</td>
									<td>{{ $assignment->created_at->diffForHumans() }}</td>
									<td>{{ $assignment->deadline->diffForHumans() }}</td>
									<td><a href="{{ route('getSingleWriterOrder', ['id'=>$assignment->id]) }}">{{ $assignment->bids }}</a></td>
									<td>${{ number_format($assignment->price) }}</td>
								</tr>
							</table>
						</div>
					@endforeach

					<div class="row">
						<div class="container text-center">{{ $assignments->links() }}</div>
					</div>
				@endif


			</div>
		</div>
	</div>
@endsection
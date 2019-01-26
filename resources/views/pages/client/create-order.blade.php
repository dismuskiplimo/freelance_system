@extends('layouts.client')

@section('title', 'Create Order')

@section('content')

	<div class="container">

		<div class="row">
			<div class="col-md-9">
				<h4>Type of Assignment</h4>
				<div class="card">
					<div class="inner-grey">
						<div class="row">
							<div class="col-md-3 padding-t-30 text-muted">
								
								<div class="row padding-b-20">
									<div class="col-md-3">
										<i class="fa fa-dashboard big-size"></i>
									</div>
									<div class="col-md-9">
										<small>
											<p class="text-bold">Low prices</p>
											<p>Working with Writers without intermediaries </p>
										</small>
										
									</div>
								</div>

								<div class="row padding-b-30">
									<div class="col-md-3">
										<i class="fa fa-certificate big-size"></i>
									</div>
									<div class="col-md-9">
										<small>
											<p class="text-bold">Quality assurance</p>
											<p>After the completion of an order all needed corrections can be made without additional charges</p> 
										</small>
										
									</div>
								</div>

								<div class="row padding-b-30">
									<div class="col-md-3">
										<i class="fa fa-clock-o big-size"></i>
									</div>
									<div class="col-md-9">
										<small>
											<p class="text-bold">Right on time</p>
											<p>You specify the deadline</p>
										</small>
										
									</div>
								</div>

								

								
							</div>
							<div class="col-md-9">

								<form action="{{ route('postClientCreateOrder') }}" method = "post" enctype = "multipart/form-data" id = "order-form">
									{{ csrf_field() }}
									
									<ul class="nav nav-tabs hidden" role="tablist">
										<li role="presentation" class="active"><a href="#main-form-content" aria-controls="main-form-content" role="tab" data-toggle="tab">Main</a></li>
										<li role="presentation"><a href="#order-payment" aria-controls="order-payment" role="tab" data-toggle="tab">Details</a></li>
									</ul>

									<!-- Tab panes -->
									<div class="tab-content padding-t-30">
										<div role="tabpanel" class="tab-pane active" id="main-form-content">
											<div class="form-group">
												<label for="der-title">What is the Title of your Assignment? *</label>
												<input type="text" id = "create-order-title" class = "form-control required" value = "{{ old('title') }}" name = "title">
											</div>

											<div class="form-group">
												<label for="create-order-assignment-type">Select Assignment Type *</label>
												
												<select name="assignment_type_id" id="create-order-assignment-type" class="form-control required">
													<option value="" data-price="0" data-time="0"> -- select assignment type --</option>

													@foreach($assignment_types as $assignment_type)
														<option value="{{ $assignment_type->id }}"  {{ old('assignment_type_id') == $assignment_type->id ? 'selected' : '' }} data-price="{{ $assignment_type->price }}" data-time="{{ $assignment_type->min_duration }}">{{ $assignment_type->name }}</option>
													@endforeach
												</select>

												
											</div>

											<div class="form-group">
												<label for="create-order-discipline">Choose a Discipline *</label>
												
												<select name="sub_discipline_id" id="create-order-discipline" class="form-control required">
													<option value=""> -- select discipline --</option>
													
													@foreach($disciplines as $discipline)
														<optgroup label = "{{ $discipline->name }}">
															@if(count($discipline->sub_disciplines))
																@foreach($discipline->sub_disciplines as $sub_discipline)
																	<option value="{{ $sub_discipline->id }}" {{ old('sub_discipline_id') == $sub_discipline->id ? 'selected' : '' }}>{{ $sub_discipline->name }}</option>
																@endforeach
															@endif
														</optgroup>
														
													@endforeach
												</select>
												
											</div>

											<div class="form-group">
												<label for="">Instructions</label>
												<textarea name="instructions" id="" rows="6" class="form-control">{{ old('instructions') }}</textarea>
											</div>

											<div class="form-group">
												<p>
													<input type="file" name = "attachment" class = "hidden" value = "Attach file" />
													<button type = "button" class = "btn btn-disabled click-buddy">ATTACH FILE <i class="fa fa-paperclip"></i></button>
												</p>
												<p class = "text-muted">Maximum upload filesize is 20MB</p>
												
											</div>

											<div class="form-group text-center">
												<button type = "button" class="btn btn-success next-form-step-trigger"> PROCEED </button>
											</div>
										</div>
										<div role="tabpanel" class="tab-pane fade" id="order-payment">
											<div class="row">
												<div class="col-lg-7">
													<div class="form-group">
														<label for="">Pages</label>

														<div class="input-group">
															<span class="input-group-btn">
																<button class="btn btn-danger" id = "remove-page" type="button"> <i class="fa fa-minus"></i> </button>
															</span>
															<input type="number" name = "pages" id = "pages" value = "{{ old('pages') ? old('pages') : '1' }}" class = "form-control required" />
															<span class="input-group-btn">
																<button class="btn btn-success" id = "add-page" type="button"> <i class="fa fa-plus"></i> </button>
															</span>	
														</div>
														
														<p class = "text-muted"><small> ~ <span id = "words">200</span> Words</small></p>
													</div>

													<div class="form-group">
														<label for="">Deadline</label>
														<input type="text" id = "deadline" name = "deadline" value = "{{ old('deadline') }}" class = "form-control required">
													</div>

												</div>
												<div class="col-lg-5 border-left">
													<div class="form-group">
														<label for="">Type of service</label>
														<select name="type_of_service" id="" class="form-control required">
															<option value="Custom writing"{{ old('type_of_service') == "Custom writing" ? ' selected' : '' }}>Custom writing</option>
															<option value="Editing"{{ old('type_of_service') == "Editing" ? ' selected' : '' }}>Editing</option>
														</select>
													</div>

													<div class="form-group">
														<label for="">Academic level</label>
														
														<select name="academic_level_id" id="" class="form-control required">
															<option value=""> -- select academic level --</option>
															@foreach($academic_levels as $academic_level)
																<option value="{{ $academic_level->id }}"{{ old('academic_level_id') == $academic_level->id ? 'selected' :'' }}>{{ $academic_level->name }}</option>
															@endforeach
														</select>
													</div>

													<div class="form-group">
														<label for="">Format</label>
														<select name="format_id" id="" class="form-control required" >
															<option value=""> -- select format --</option>
															@foreach($formats as $format)
																<option value="{{ $format->id }}"{{ old('format_id') == $format->id ? 'selected' :'' }}>{{ $format->name }}</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>

											
											<hr>
											
											<div class="row margin-tb-30">
												

												<div class="col-lg-5">
													<label for="">Amount payable</label>
													<h4 style = "margin-top: 8px;margin-bottom:10px"><span id = "money-span">not defined</span></h4>
													
												</div>
											</div>

											<input type="hidden" id = "commission-percent" value = "{{ $commission }}" />

											<div class="form-group">
												<button type = "button" class="btn btn-info previous-form-step-trigger"> <i class="fa fa-chevron-left"></i> PREVIOUS </button>
												<button type = "submit" class="btn btn-success pull-right">POST TO AUCTION</button>
											</div>
											
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				
			</div>
			
		</div>
	</div>

@endsection

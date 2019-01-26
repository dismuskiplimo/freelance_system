@extends('layouts.writer')

@section('title', 'Qualifications')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h4 class = "margin-b-20">Qualification</h4>
				<div class="card">
					@include('includes.writer.nav-settings')

					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">ABOUT ME</p>
								<p>This section is visible to all {{ env('APP_NAME') }} users</p>
							</div>
							<div class="col-md-9">
								<form action="{{ route('postWriterAbout') }}" method = "POST">
									{{ csrf_field() }}
									<div class="form-group">
										<label for="">Describe yourself in a few words (max 100 char)</label>
										<input type="text" value = "{{ old('about') ? old('about') : Auth::user()->about }}" class="form-control" name = "about" required>
									</div>

									<div class="form-group">
										<label for="">Your professional bio (max 240 char)</label>
										<textarea id="" rows="5" name = "professional_bio" class="form-control" required>{{ old('professional_bio') ? old('professional_bio') : Auth::user()->professional_bio }}</textarea>
										<span class="text-muted">(remaining characters: 240)</span>
									</div>

									<div class="form-group">
										<button class="btn btn-primary">SAVE</button>
									</div>
									
								</form>
							</div>
							
						</div>
					</div>

					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">EDUCATION</p>
								<p>This section is visible to all {{ env('APP_NAME') }} users, and is only filled once</p>
							</div>
							<div class="col-md-6">
								<form action="{{ route('postWriterEducation') }}" method = "POST">
									{{ csrf_field() }}
									<div class="form-group">
										<label for="">Educational attainment</label>
										<select name="academic_level_id" id="" class="form-control"{{ Auth::user()->academic_level_id == null || empty(Auth::user()->academic_level_id) ? '': ' disabled = "disabled"' }}>
											@foreach($academic_levels as $academic_level)
												<option value="{{ $academic_level->id }}"{{ old('academic_level_id') || Auth::user()->academic_level_id == $academic_level->id ? ' selected' :'' }}>{{ $academic_level->name }}</option>
											@endforeach
										</select>
									</div>

									<div class="form-group">
										<label for="">Graduated from</label>
										<input type="text" value = "{{ old('school') ? old('school') : Auth::user()->school }}" class="form-control" name = "school" required{{ Auth::user()->school == null || empty(Auth::user()->school) ? '': ' disabled = "disabled"' }}>
									</div>

									<div class="form-group">
										<label for="">Field of Specialization</label>
										<input type="text" value = "{{ old('field_of_specialization') ? old('field_of_specialization') : Auth::user()->field_of_specialization }}" class="form-control" name = "field_of_specialization" required{{ Auth::user()->field_of_specialization == null || empty(Auth::user()->field_of_specialization) ? '': ' disabled = "disabled"' }}>
									</div>

									

									@if(Auth::user()->school == null || empty(Auth::user()->school))
										<div class="form-group">
											<button class="btn btn-primary">SAVE</button>
										</div>
									@endif
									
								</form>
							</div>
							
						</div>
					</div>

					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">DETAILS</p>
								<p>This section is visible only by {{ env('APP_NAME') }} administration, and you only have one shot</p>
							</div>
							<div class="col-md-9">
								<form action="{{ route('postWriterPrivateDetails') }}" method = "POST">
									{{ csrf_field() }}
									<div class="form-group">
										<label for="">Describe yourself in a few words (max 100 char)</label>
										<input type="text" class="form-control" value = "{{ old('my_details') ? old('my_details') : Auth::user()->my_details }}" name = "my_details" required{{ Auth::user()->my_details == null || empty(Auth::user()->my_details) ? '': ' disabled = "disabled"' }}>
									</div>

									<div class="form-group">
										<label for="">Your academic and writing experience</label>
										<textarea id="" rows="5" name = "academic_experience" class="form-control" required{{ Auth::user()->academic_experience == null || empty(Auth::user()->academic_experience) ? '': ' disabled = "disabled"' }}>{{ old('academic_experience') ? old('academic_experience') : Auth::user()->academic_experience }}</textarea>
										<span class="text-muted">(remaining characters: 240)</span>
									</div>

									@if(Auth::user()->my_details == null || empty(Auth::user()->my_details))
										<div class="form-group">
											<button class="btn btn-primary">SAVE</button>
										</div>
									@endif
									
								</form>
							</div>
							
						</div>
					</div>

					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">LANGUAGES</p>
								<p>This section is visible to all {{ env('APP_NAME') }} users</p>
							</div>
							<div class="col-md-6">
								<?php 
									$my_languages = Auth::user()->my_languages()->orderBy('created_at','desc')->get(); 
									$language_array = [];

									if(count($my_languages)){
										foreach($my_languages as $lang){
											$language_array[] = $lang->language_id;
										}
										
									} 



								?>


								<form action="{{ route('postWriterLanguage') }}" method = "POST">
									{{ csrf_field() }}
									<div class="form-group">
										<label for="">Language</label>
										<select name="language_id" id="" class="form-control">
											@if(count(App\Language::orderBy('name','ASC')->get()))
												@foreach(App\Language::orderBy('name','ASC')->get() as $language)
													@if(in_array($language->id, $language_array))
														<?php continue; ?>
													@endif

													<option value="{{ $language->id }}"{{ old('language_id') == $language->id ? ' selected' : '' }}>{{ $language->name }}</option>
												@endforeach
											@endif
											
										</select>
									</div>

									<div class="form-group">
										<button class="btn btn-primary">ADD</button>
									</div>

									@if(count($my_languages))
										<p><b>My languages</b></p>
										<div class="row">
											@foreach($my_languages as $my_language)
												<div class="col-sm-6">
													<p class = "well"><i class="fa fa-angle-double-right text-success"></i> {{ $my_language->language ? $my_language->language->name : '' }} <a class="pull-right" title = "delete" href="{{ route('postWriterDeleteLanguage',['id'=>$my_language->id]) }}"> <i class="fa fa-times text-danger"></i></a></p>
												</div>
												
											@endforeach
										</div>	
										<br>
									@endif
									
									
									
									
								</form>
							</div>
							
						</div>
					</div>

					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">ASSIGNMENT TYPES</p>
								<p>This section is visible to all {{ env('APP_NAME') }} users</p>
							</div>
							<div class="col-md-6">
								<?php 
									$my_assignment_types = Auth::user()->my_assignment_types()->orderBy('created_at','desc')->get(); 
									$assignment_types_array = [];

									if(count($my_assignment_types)){
										foreach($my_assignment_types as $ass){
											$assignment_types_array[] = $ass->assignment_type_id;
										}
										
									} 

								?>

								<form action="{{ route('postWriterAssignmentType') }}" method = "POST">
									{{ csrf_field() }}
									
									<div class="form-group">
										<label for="">Assignment Types</label>
										<select name="assignment_type_id" id="" class="form-control">
											@if(count(App\Assignment_type::orderBy('name','ASC')->get()))
												@foreach(App\Assignment_type::orderBy('name','ASC')->get() as $assignment_type)
													@if(in_array($assignment_type->id, $assignment_types_array))
														<?php continue; ?>
													@endif

													<option value="{{ $assignment_type->id }}"{{ old('assignment_type_id') == $assignment_type->id ? ' selected' : '' }}>{{ $assignment_type->name }}</option>
												@endforeach
											@endif
											
										</select>
									</div>

									<div class="form-group">
										<button class="btn btn-primary">ADD</button>
									</div>

									@if(count($my_assignment_types))
										<p><b>My Assignment Types</b></p>
										<div class="row">
											@foreach($my_assignment_types as $my_assignment_type)
												<div class="col-sm-6">
													<p class = "well"><i class="fa fa-angle-double-right text-success"></i> {{ $my_assignment_type->assignment_type ? $my_assignment_type->assignment_type->name : '' }} <a class="pull-right" title = "delete" href="{{ route('postWriterDeleteAssignmentType',['id'=>$my_assignment_type->id]) }}"> <i class="fa fa-times text-danger"></i></a></p>
												</div>
												
											@endforeach
										</div>	
										<br>
									@endif
									
									
									
									
								</form>
							</div>
							
						</div>
					</div>

					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">DISCIPLINES</p>
								<p>This section is visible to all {{ env('APP_NAME') }} users</p>
							</div>
							<div class="col-md-6">
								<?php 
									$my_disciplines = Auth::user()->my_disciplines()->orderBy('created_at','desc')->get(); 
									$disciplines_array = [];

									if(count($my_disciplines)){
										foreach($my_disciplines as $disc){
											$disciplines_array[] = $disc->discipline_id;
										}
										
									} 

								?>
								

								<form action="{{ route('postWriterDiscipline') }}" method = "POST">
									{{ csrf_field() }}
									<div class="form-group">
										<label for="">Discipline</label>
										<select name="discipline_id" id="" class="form-control">
											@if(count(App\Sub_discipline::orderBy('name','ASC')->get()))
												@foreach(App\Sub_discipline::orderBy('name','ASC')->get() as $discipline)
													@if(in_array($discipline->id, $disciplines_array))
														<?php continue; ?>
													@endif

													<option value="{{ $discipline->id }}"{{ old('discipline_id') == $discipline->id ? ' selected' : '' }}>{{ $discipline->name }}</option>
												@endforeach
											@endif
											
										</select>
									</div>

									<div class="form-group">
										<button class="btn btn-primary">ADD</button>
									</div>

									@if(count($my_disciplines))
										<p><b>My Disciplines</b></p>
										<div class="row">
											@foreach($my_disciplines as $my_discipline)
												<div class="col-sm-6">
													<p class = "well"><i class="fa fa-angle-double-right text-success"></i> {{ $my_discipline->discipline ? $my_discipline->discipline->name : '' }} <a class="pull-right" title = "delete" href="{{ route('postWriterDeleteDiscipline',['id'=>$my_discipline->id]) }}"> <i class="fa fa-times text-danger"></i></a></p>
												</div>
												
											@endforeach
										</div>	
										<br>
									@endif
									
									
									
									
								</form>
							</div>
							
						</div>
					</div>

				</div>


			</div>
		</div>
			
	</div>
	
@endsection
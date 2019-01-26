@extends('layouts.admin')

<?php 
	$title = $user->name . ' (' . $user->user_type . ') - '; 
	$title .= $user->active == 0 ? 'Inactive':'Active';
?>

@section('title', $title)

@section('content')

<div class="row">
	<div class="col-sm-2 text-center">
		<img src="{{ $user->image ? asset('images/uploads') . '/' .$user->image : asset('images/new-user.png') }}" class = "img-responsive" style = "margin-bottom:20px" alt="{{ $user->username }}">
		<p>name <br><strong>{{ $user->name }}</strong></p>
		<p>username <br><strong>{{ $user->username }}</strong></p>
		<p>email <br><strong>{{ $user->email }}</strong></p>
		<p>last seen <br><strong>{{ $user->last_seen->diffForHumans() }}</strong></p>
		<p>user type <br><strong>{{ $user->user_type }}</strong></p>
		@if($user->active == 1)
			<form action="{{ route('postDeactivateUser',['id'=>$user->id]) }}" method = "POST">
				{{ csrf_field() }}
				<button type = "submit" class="btn btn-sm btn-danger">Deactivate</button>
			</form>
		@else
			<form action="{{ route('postActivateUser',['id'=>$user->id]) }}" method = "POST">
				{{ csrf_field() }}
				<button type = "submit" class="btn btn-sm btn-success">Activate</button>
			</form>
		@endif
	</div>

	<div class="col-sm-10">
		<table class="table-responsive table table-striped">
			@if($user->user_type=='WRITER')
			<tr>
				<th>Views</th>
				<td>{{ number_format($user->views) }}</td>
			</tr>

			<tr>
				<th>Orders Complete</th>
				<td>{{ number_format($user->orders_complete) }}</td>
			</tr>
			@endif

			<tr>
				<th>DOB</th>
				<td>{{ $user->dob }}</td>
			</tr>

			<tr>
				<th>Phone</th>
				<td>{{ $user->phone }}</td>
			</tr>

			<tr>
				<th>Address</th>
				<td>{{ $user->address }}</td>
			</tr>

			<tr>
				<th>City</th>
				<td>{{ $user->city }}</td>
			</tr>

			<tr>
				<th>Country</th>
				<td>{{ $user->country ? $user->country->country_name : '' }}</td>
			</tr>

			<tr>
				<th>School</th>
				<td>{{ $user->school }}</td>
			</tr>
			
			<tr>
				<th>Academic level</th>
				<td>{{ $user->academic_level ? $user->academic_level->name : '' }}</td>
			</tr>

			<tr>
				<th>Field of Specialization</th>
				<td>{{ $user->field_of_specialization }}</td>
			</tr>

			@if($user->user_type=='WRITER')
			<tr>
				<th>About me</th>
				<td>{{ $user->about }}</td>
			</tr>

			<tr>
				<th>Professional Bio</th>
				<td>{{ $user->professional_bio }}</td>
			</tr>

			<tr>
				<th>My Details(private)</th>
				<td>{{ $user->my_details }}</td>
			</tr>

			<tr>
				<th>Academic experience (private)</th>
				<td>{{ $user->academic_experience }}</td>
			</tr>
			@endif

		</table>

		<p><a href="" data-toggle="modal" data-target="#edit-user" class="btn btn-info pull-right">Edit User</a></p>
	</div>
</div>

<div class="modal fade" id = "edit-user">
	<div class="modal-dialog modal-lg">
		<form action="{{ route('postAdminUserUpdate',['id'=>$user->id]) }}" method = "POST">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title">Edit User</h4>
			</div>
			<div class="modal-body">
				{{ csrf_field() }}
				<input type="hidden" name = "_method" value = "PATCH" />
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="">Name</label>
							<input type="text" name = "name" value = "{{ old('name') ? : $user->name }}" class="form-control border-input" required>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="">Username</label>
							<input type="text" name = "username" value = "{{ old('username') ? : $user->username }}" class="form-control border-input" required>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="">Email</label>
							<input type="email" name = "email" value = "{{ old('email') ? : $user->email }}" class="form-control border-input" required>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="">User type</label>
							@if(old('user_type'))
								<select name="user_type" id="user_type" class="form-control border-input" required>
		                            <option value="CLIENT"{{ old('user_type') == "CLIENT" ? ' selected'  : '' }}>CLIENT</option>
		                            <option value="WRITER"{{ old('user_type') == "WRITER" ? ' selected'  : '' }}>WRITER</option>
		                        </select>
	                        @else
								<select name="user_type" id="user_type" class="form-control border-input" required>
		                            <option value="CLIENT"{{ $user->user_type == "CLIENT" ? ' selected'  : '' }}>CLIENT</option>
		                            <option value="WRITER"{{ $user->user_type == "WRITER" ? ' selected'  : '' }}>WRITER</option>
		                        </select>
	                        @endif
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="">DOB</label>
							<input type="text" name = "dob" value = "{{ old('dob') ? : $user->dob }}" class="form-control border-input dob">
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="">Phone number</label>
							<input type="text" name = "phone" value = "{{ old('phone') ? : $user->phone }}" class="form-control border-input">
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="">Address</label>
							<input type="text" name = "address" value = "{{ old('address') ? : $user->address }}" class="form-control border-input">
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="">City</label>
							<input type="text" name = "city" value = "{{ old('city') ? : $user->city }}" class="form-control border-input">
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="">Country</label>
							<select name="country_id" id="country_id" class="form-control border-input">
	                            @foreach(App\Country::get() as $country)
									@if(old('country_id'))
										<option value="{{ $country->id }}"{{ old('country_id') == $country->id ? ' selected'  : '' }}>{{ $country->country_name }}</option>
									@else
										<option value="{{ $country->id }}"{{ $user->country_id == $country->id ? ' selected'  : '' }}>{{ $country->country_name }}</option>
									@endif
	                            @endforeach
	                        </select>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="">School</label>
							<input type="text" name = "school" value = "{{ old('school') ? : $user->school }}" class="form-control border-input">
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="">Academic level</label>
							<select name="academic_level_id" id="academic_level_id" class="form-control border-input">
	                            @foreach(App\Academic_level::get() as $academic_level)
									@if(old('academic_level_id'))
										<option value="{{ $academic_level->id }}"{{ old('academic_level_id') == $academic_level->id ? ' selected'  : '' }}>{{ $academic_level->name }}</option>
									@else
										<option value="{{ $academic_level->id }}"{{ $user->academic_level_id == $academic_level->id ? ' selected'  : '' }}>{{ $academic_level->name }}</option>
									@endif
	                            @endforeach
	                        </select>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label for="">Field of specialization</label>
							<input type="text" name = "field_of_specialization" value = "{{ old('field_of_specialization') ? : $user->field_of_specialization }}" class="form-control border-input">
						</div>
					</div>

					@if($user->user_type == 'WRITER')
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">About me</label>
								<input type="text" name = "about" value = "{{ old('about') ? : $user->about }}" class="form-control border-input">
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label for="">My details</label>
								<input type="text" name = "my_details" value = "{{ old('my_details') ? : $user->my_details }}" class="form-control border-input">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Professional bio</label>
								<textarea name="professional_bio" rows="4" class="form-control border-input">{{ old('professional_bio') ? : $user->professional_bio }}</textarea>
								
							</div>
						</div>	

						<div class="col-sm-6">
							<div class="form-group">
								<label for="">Academic experience</label>
								<textarea name="academic_experience" rows="4" class="form-control border-input">{{ old('academic_experience') ? : $user->academic_experience }}</textarea>
							</div>


						</div>						
					@endif



					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        		<button type="type" class="btn btn-primary">Save changes</button>
			</div>
		</div>
		</form>
	</div>
</div>
    
@endsection
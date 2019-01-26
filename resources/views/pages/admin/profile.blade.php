@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
	<?php $user = Auth::user(); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="card card-user">
                    <div class="image">
                        <img src="{{ $user->image ? asset('images/uploads') . '/' . $user->image : asset('images/new-user.png') }}" alt=""/>
                    </div>
                    <div class="content">
                        <div class="author">
                          <form action="{{ route('postAdminUpdateProfilePicture') }}" method = "POST" enctype = "multipart/form-data" id = "image-form">
                          	{{ csrf_field() }}
                          	<img class="avatar border-white click-buddy" src="{{ $user->image ? asset('images/uploads') . '/' . $user->image : asset('images/new-user.png') }}" alt="{{ $user->name }}"/>
                          	<input type="file" style = "display:none" class = "auto-submit" name = "image">
                          </form>
                          <h4 class="title">{{ $user->name }}<br />
                             <a href=""><small>{{ '@' . $user->username }}</small></a>
                          </h4>
                        </div>
                        <p class="description text-center">
                            {!! $user->about ? '"' . nl2br($user->about) . '"' : '' !!}
                        </p>
                    </div>
                    
                </div>

                <div class="card">
                	<div class="header">
                		
                		<h4 class="title">Update password</h4>	
                		
                	</div>
                	<div class="content">
                		<form action="{{ route('postAdminUpdatePassword') }}" method = "POST">
                			{{ csrf_field() }}
                			<input type="hidden" name = "_method" value = "PATCH">

                			<div class="form-group">
								<label for="">Old password*</label>
								<input type="password" name = "old_password" class = "form-control border-input" required />										
							</div>

							<div class="form-group">
								<label for="">New password*</label>
								<input type="password" name = "new_password" class = "form-control border-input" required />										
							</div>

							<div class="form-group">
								<label for="">Confirm new password*</label>
								<input type="password" name = "new_password_confirmation" class = "form-control border-input" required />										
							</div>

							<div class="form-group">
								<button type = "submit" class = "btn btn-primary btn-fill">Change password</button>
							</div>
                		</form>
                	</div>
                </div>
                
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Edit Profile</h4>
                    </div>
                    <div class="content">
                        <form action = "{{ route('postAdminProfile') }}" method = "POST">
                        	{{ csrf_field() }}
							<input type="hidden" name = "_method" value = "PATCH">


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name = "name" class="form-control border-input" placeholder="Name" value="{{ old('name') ?: $user->name }}" required>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name = "username" class="form-control border-input" placeholder="Username" value="{{ old('username') ?: $user->username }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email address</label>
                                        <input type="email" name = "email" class="form-control border-input" placeholder="Email" value = "{{ old('email') ?: $user->email }}" required>
                                    </div>
                                </div>
                            </div>

                            

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" name = "address" class="form-control border-input" placeholder="Home Address" value="{{ old('address') ?: $user->address }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name = "city" class="form-control border-input" placeholder="City" value="{{ old('city') ?: $user->city }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label>
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
                               
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>About Me</label>
                                        <textarea name = "about" rows="5" class="form-control border-input" placeholder="A little about you" value="">{{ $user->about }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-info btn-fill btn-wd">Update Profile</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
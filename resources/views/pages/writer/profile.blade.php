@extends('layouts.writer')

@section('title', 'My profile')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h4 class = "margin-b-20">Personal info</h4>
				<div class="card">
					@include('includes.writer.nav-settings')
					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">USER PIC</p>
							</div>
							<div class="col-md-3">
								<img src="{{ empty(Auth::user()->image) ? asset('images/new-user.png') : asset('images/uploads/'.Auth::user()->image) }}" alt="{{ Auth::user()->name }}" class = "img-responsive">
								
							</div>
							<div class="col-md-4 margin-b-20">
								<form action="{{ route('postWriterUpdateProfilePicture') }}" id = "image-form" method = "POST" enctype = "multipart/form-data">
									{{ csrf_field() }}
									<button type = "button" class = "btn-info btn margin-vertical click-buddy" > <i class="fa fa-upload"></i> UPLOAD IMAGE</button>
									<input type="file" name = "image" class = "hidden auto-submit" />
								</form>
							</div>
						</div>
					</div>

					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">NAME</p>
							</div>
							<div class="col-md-4">
								<form action="" method = "POST">
									{{ csrf_field() }}
									<div class="form-group">
										<label for="">Username</label>
										<input type="text" class = "form-control" value = "{{ Auth::user()->username }}"  name = "username" disabled="disabled">
									</div>

									<div class="form-group">
										<label for="">Name</label>
										<input type="text" class="form-control" value = "{{ Auth::user()->name }}" name = "name" placeholder = "name" disabled="disabled" />
									</div>

									
								</form>
							</div>
						</div>
					</div>

					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">PAYPAL EMAIL</p>
							</div>

							


							<div class="col-md-4">
								<div class="form-group">
									<label for="">PayPal Email</label>
									<input type="email" class = "form-control" value = "{{ Auth::user()->paypal_email }}" name = "paypal_email" disabled="disabled">
								</div>

								<div class="form-group">
									<button type = "button" data-toggle = "modal" data-target = "#update-paypal-modal" class="btn btn-primary">ADD / CHANGE</button>
								</div>

								<div class="modal fade" id="update-paypal-modal">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">Add / Update PayPal email</h4>
											</div>
											<div class="modal-body">
												<form action="{{ route('postWriterUpdatePaypal') }}" method = "POST">
													{{ csrf_field() }}
													<h4>PayPal details exactly as they appear on your PayPal account</h4>
													<div class="row">
														<div class="col-sm-12">
															<div class="form-group">
																<label for="">Email</label>
																<input type="email" class = "form-control" value = "{{ Auth::user()->paypal_email }}" name = "paypal_email" required>
															</div>
														</div>

														<div class="col-sm-6">
															<div class="form-group">
																<label for="">First Name</label>
																<input type="text" name = "fName" class="form-control" required />
															</div>
														</div>

														<div class="col-sm-6">
															<div class="form-group">
																<label for="">Last Name</label>
																<input type="text" name = "lName" class="form-control" required />
															</div>
														</div>
													</div>

													<div class="form-group">
														<button type = "submit" class="btn btn-primary">SAVE</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">DATE OF BIRTH</p>
							</div>
							<div class="col-md-4">
								<form action="{{ route('postWriterDOBInfo') }}" method = "POST">
									{{ csrf_field() }}

									<div class="form-group">
										
										<input type="text" class="form-control{{ Auth::user()->dob == null || empty(Auth::user()->dob) ? ' dob' : '' }}" value="{{ old('dob') ? old('dob') : Auth::user()->dob }}" name = "dob" required{{ Auth::user()->dob == null || empty(Auth::user()->dob) ? '' : ' disabled = "disabled"' }} />
									</div>

									@if(Auth::user()->dob == null || empty(Auth::user()->dob))
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
								<p class = "text-bold">CONTACT INFORMATION</p>
							</div>
							<div class="col-md-8">
								<form action="{{ route('postWriterContactInfo') }}" method = "POST">
									{{ csrf_field() }}
									
									
									
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="">Country</label>
												<select name="country_id" id="" class="form-control">
													@foreach($countries as $country)
														<option value="{{ $country->id }}"{{ old('country_id') || Auth::user()->country_id == $country->id ? 'selected' : '' }}>{{ $country->country_name }}</option>
													@endforeach
													
												</select>
											</div>

											<div class="form-group">
												<label for="">City</label>
												<input type="text" name = "city" value = "{{ old('city') ? old('city') : Auth::user()->city }}" class = "form-control">
											</div>
										</div>
										<div class="col-md-8">
											
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label for="">Email</label>
														<input type="text" disabled="disabled" value = "{{ Auth::user()->email }}" class="form-control">
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="">Address</label>
														<input type="text" name = "address" value = "{{ old('address') ? old('address') : Auth::user()->address }}" class="form-control">
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label for="">Phone number</label>
														<input type="text" name = "phone" value = "{{ old('phone') ? old('phone') : Auth::user()->phone }}" class="form-control">
													</div>
												</div>
											</div>
										</div>

									</div>
									
									<div class="form-group">
										<button type = "submit" class="btn btn-primary">SAVE</button>
									</div>

								</form>
							</div>
						</div>
					</div>

					<div class="inner-grey">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">PASSWORD</p>
							</div>
							<div class="col-md-4">
								<form action="{{ route('postUpdateWriterPassword') }}" method = "POST">
									{{ csrf_field() }}
									
									<div class="form-group">
										<label for="">Old password*</label>
										<input type="password" name = "old_password" class = "form-control" required />										
									</div>

									<div class="form-group">
										<label for="">New password*</label>
										<input type="password" name = "new_password" class = "form-control" required />										
									</div>

									<div class="form-group">
										<label for="">Confirm new password*</label>
										<input type="password" name = "new_password_confirmation" class = "form-control" required />										
									</div>

									<div class="form-group">
										<button type = "submit" class = "btn btn-primary">CHANGE</button>
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
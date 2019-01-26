@extends('layouts.client')

@section('title', 'My profile')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h4>Settings</h4>
				<div class="card">
					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">USER PIC</p>
							</div>
							<div class="col-md-3">
								<img src="{{ empty(Auth::user()->image) ? asset('images/new-user.png') : asset('images/uploads/'.Auth::user()->image) }}" alt="{{ Auth::user()->name }}" class = "img-responsive">
								
							</div>
							<div class="col-md-4 margin-b-20">
								<form action="{{ route('postClientUpdateProfilePicture') }}" method = "POST" enctype = "multipart/form-data" id = "image-form">
									{{ csrf_field() }}
									<input type="file" name = "image" class = "hidden auto-submit" />
									<button type = "button" class = "btn-info btn margin-vertical click-buddy" > <i class="fa fa-upload"></i> UPLOAD IMAGE</button>
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
								<form action="{{ route('postClientInfo') }}" method = "POST">
									{{ csrf_field() }}
									<div class="form-group">
										<label for="">Email</label>
										<input type="email" class = "form-control" value = "{{ Auth::user()->email }}" name = "email" disabled="disabled">
									</div>

									<div class="form-group">
										<label for="">Name</label>
										<input type="text" class="form-control" value = "{{ Auth::user()->name }}" disabled="disabled" name = "name" placeholder = "name" required />
									</div>

									<div class="form-group">
										<button type = "submit" class="btn btn-primary">SAVE</button>
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
												<form action="{{ route('postClientUpdatePaypal') }}" method = "POST">
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
								<p class = "text-bold">EDUCATION</p>
							</div>
							<div class="col-md-4">
								<form action="{{ route('postClientEducation') }}" method = "POST">
									{{ csrf_field() }}
									<div class="form-group">
										<label for="">Educational attainment</label>
										<select name="academic_level_id" id="" class="form-control">
											@foreach($academic_levels as $academic_level)
												<option value="{{ $academic_level->id }}" {{ Auth::user()->academic_level_id == $academic_level->id ? 'selected' : '' }}>{{ $academic_level->name }}</option>
											@endforeach
										</select>
									</div>

									<div class="form-group">
										<label for="">Graduated from</label>
										<input type="text" class="form-control" value = "{{ Auth::user()->school }}" name = "school" required />
									</div>

									<div class="form-group">
										<label for="">Field of Specialization</label>
										<input type="text" class="form-control" value = "{{ Auth::user()->field_of_specialization }}" name = "field_of_specialization" required />
									</div>

									<div class="form-group">
										<button type = "submit" class="btn btn-primary">SAVE</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="inner-grey margin-b-20">
						<div class="row">
							<div class="col-md-3">
								<p class = "text-bold">CONTACT INFORMATION</p>
							</div>
							<div class="col-md-4">
								<form action="{{ route('postClientContacts') }}" method = "POST">
									{{ csrf_field() }}
									
									<div class="form-group">
										<label for="">Email</label>
										<input type="email" value = "{{ Auth::user()->email }}" disabled="disabled" class="form-control" />
									</div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Country</label>
												<select name="country_id" id="" class="form-control">
													@foreach($countries as $country)
														<option value="{{ $country->id }}" {{ Auth::user()->country_id == $country->id ? 'selected' : '' }}>{{ $country->country_name }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">City</label>
												<input type="text" name = "city" value = "{{ Auth::user()->city }}" class="form-control">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="">Phone number</label>
												<input type="text" name = "phone" value = "{{ Auth::user()->phone }}" class="form-control">
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
								<form action="{{ route('postClientUpdatePassword') }}" method = "POST">
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
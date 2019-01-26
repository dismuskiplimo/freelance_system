		@if(!Auth::check() || (Auth::check() && Auth::user()->user_type === 'CLIENT'))
			
			<!-- Modal -->
			<div class="modal fade" id="calculator-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Price calculator</h4>
						</div>
						<div class="modal-body">
							<form action="" class = "" method="POST">
								<div class="form-group">
									<select name = "type" class = "form-control" required>
				                        <option value="0" disabled="">Select Assignment Type</option>
				                        <option selected="" value="1">Essay</option>
				                        <option value="18">Admission / Scholarship Essay</option>
				                        <option value="12">Research Paper</option>
				                        <option value="26">Research Proposal</option>
				                        <option value="4">Coursework</option>
				                        <option value="2">Term paper</option>
				                        <option value="5">Article</option>
				                        <option value="22">Literature / Movie review</option>
				                        <option value="9">Reports</option>
				                        <option value="3">Dissertation</option>
				                        <option value="29">Thesis</option>
				                        <option value="30">Thesis Proposal</option>
				                        <option value="13">Creative Writing</option>
				                        <option value="11">Business Plan</option>
				                        <option value="15">Speech / Presentation</option>
				                        <option value="7">Outline</option>
				                        <option value="14">Annotated Bibliography</option>
				                        <option value="6">Dissertation Proposal</option>
				                        <option value="17">Proofreading</option>
				                        <option value="25">Paraphrasing</option>
				                        <option value="28">PowerPoint Presentation</option>
				                        <option value="27">Personal Statement</option>
				                        <option value="24">Non-word Assignments</option>
				                        <option value="23">Math Assignment</option>
				                        <option value="21">Lab Report</option>
				                        <option value="20">Code</option>
				                        <option value="19">Case Study</option>
				                        <option value="16">Other types</option>   
									</select>
								</div>

								<div class="form-group">
									<select name="level" id="" class = "form-control">
				                        <option value="0" disabled="">Select level</option>
				                        <option selected="" value="1">High School</option>
				                        <option value="4">Undergraduate/Bachelor</option>
				                        <option value="2">Masters</option>
				                        <option value="3">PHD</option>      
									</select>
								</div>

								<div class="form-group">
									<label for = "">Deadline</label>
									<div class="input-group">
										<input type="text" name = "deadline" class = "form-control" id = "deadline" required>
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
									
								</div>

								<div class="form-group">
									<label for="">Pages</label>
									<input type="text" id = "pages" value = "1" name = "pages" class = "form-control">
									<p>~ <span class="page-count" id = "words">250</span> Words</p>
								</div>
								
							</form>
						</div>
						<div class="modal-footer">
							<div class="form-group">
								<a href="{{ url('login') }}" class = "btn btn-success btn-block"> PLACE ORDER </a>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif

		@if(!Auth::check())
			
			<!-- Modal -->
			<div class="modal fade" id="auth-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">LOGIN</h4>
						</div>
						<div class="modal-body">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#login-tab" aria-controls="login-tab" role="tab" data-toggle="tab">Login</a></li>
								<li role="presentation"><a href="#signup-tab" aria-controls="signup-tab" role="tab" data-toggle="tab">Signup</a></li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="login-tab">
									<form class="auth-submit" role="form" method="POST" action="{{ url('/login') }}">
			                            <div class = "shake-div padding-t-30">
			                                {{ csrf_field() }}

			                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
			                                    <label for="email">E-Mail / Username</label>
			                                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}"  autofocus>

			                                    @if ($errors->has('email'))
			                                        <span class="help-block">
			                                            <strong>{{ $errors->first('email') }}</strong>
			                                        </span>
			                                    @endif
			                                </div>

			                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
			                                    <label for="password">Password</label>
			                                    <input id="password" type="password" class="form-control" name="password" >

			                                    @if ($errors->has('password'))
			                                        <span class="help-block">
			                                            <strong>{{ $errors->first('password') }}</strong>
			                                        </span>
			                                    @endif
			                                </div>

			                                

			                                <div class="form-group">
			                                    
			                                    <p class = "text-right"><a class="btn btn-link" href="{{ url('/password/reset') }}"> Forgot Your Password? </a></p><br />
			                                    
			                                    <button type="submit" class="btn btn-primary btn-block">
			                                        Login
			                                    </button>
			                                </div>

			                                

			                                <div class="form-group">
			                                    <div class="checkbox">
			                                        <label>
			                                            <input type="checkbox" name="remember"> Remember Me
			                                        </label>
			                                    </div>
			                                </div>

			                                <div class="form-group">
			                                    <span class = "loading">
			                                        <i class="fa fa-circle-o-notch fa-spin"></i>
			                                    </span>
			                                    <span class = "errors"></span>
			                                </div>
			                            </div>
			                        </form>
								</div>

								<div role="tabpanel" class="tab-pane fade" id="signup-tab">
									<form class="auth-submit" role="form" method="POST" action="{{ url('/register') }}">
			                            <div class="shake-div padding-t-30">   
			                                {{ csrf_field() }}
			                                
			                                <div class="row">
			                                	<div class="col-lg-6">
			                                		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					                                    <label for="name">Name *</label>
					                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

					                                    @if ($errors->has('name'))
					                                        <span class="help-block">
					                                            <strong>{{ $errors->first('name') }}</strong>
					                                        </span>
					                                    @endif
					                                </div>
			                                	</div>
			                                	<div class="col-lg-6">
			                                		<div class="form-group{{ $errors->has('user_type') ? ' has-error' : '' }}">
					                                    <label for="user_type">I want to *</label>
					                                    
					                                    
					                                    <select name="user_type" id="user_type" class="form-control">
					                                        <option value="CLIENT"{{ old('user_type') == "CLIENT" ? ' selected'  : '' }}>Hire Freelancers</option>
					                                        <option value="WRITER"{{ old('user_type') == "WRITER" ? ' selected'  : '' }}>Work</option>
					                                    </select>
					                                    
					                                    @if ($errors->has('user_type'))
					                                        <span class="help-block">
					                                            <strong>{{ $errors->first('usertype') }}</strong>
					                                        </span>
					                                    @endif
					                                </div>
			                                	</div>
			                                </div>

											<div class="row">
												

												<div class="col-md-6">
													<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					                                    <label for="email">E-Mail Address *</label>
					                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

					                                    @if ($errors->has('email'))
					                                        <span class="help-block">
					                                            <strong>{{ $errors->first('email') }}</strong>
					                                        </span>
					                                    @endif
					                                </div>
												</div>

												<div class="col-md-6">
													<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					                                    <label for="username">Username *</label>
					                                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>

					                                    @if ($errors->has('username'))
					                                        <span class="help-block">
					                                            <strong>{{ $errors->first('username') }}</strong>
					                                        </span>
					                                    @endif
					                                </div>
												</div>
											</div>	
										
			                                
			                                <div class="row">
			                                    <div class="col-md-6">
			                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
			                                            <label for="password">Password *</label>
			                                            <input id="password" type="password" class="form-control" name="password" required>

			                                            @if ($errors->has('password'))
			                                                <span class="help-block">
			                                                    <strong>{{ $errors->first('password') }}</strong>
			                                                </span>
			                                            @endif
			                                        </div>
			                                    </div>
			                                    <div class="col-md-6">
			                                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
			                                            <label for="password-confirm">Confirm Password *</label>

			                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

			                                            @if ($errors->has('password_confirmation'))
			                                                <span class="help-block">
			                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
			                                                </span>
			                                            @endif
			                                        </div>
			                                    </div>
			                                </div>

			                                <div class="form-group">
			                                    <div class="checkbox">
			                                        
			                                        <label>
			                                            <input type="checkbox" name="terms"> I accept terms and conditions *
			                                        </label>

			                                        <p><a href="{{ route('getTerms') }}">Terms and conditions</a></p>
			                                    </div>
			                                </div>

			                                <div class="form-group">
			                                    <button type="submit" class="btn btn-primary btn-block">Register</button>
			                                </div>

			                                 <div class="form-group">
			                                    <span class = "loading">
			                                        <i class="fa fa-circle-o-notch fa-spin"></i>
			                                    </span>
			                                    <span class = "errors"></span>
			                                </div>
			                            </div>
			                        </form>
								</div>	
							</div>
						</div>
						
					</div>
				</div>
			</div>
		@endif


		<div class="container-fluid border-top">
			<div class="row">
				<div class="container">
					<div class="row padding-tb-50 ">
						<div class="col-lg-10 col-lg-offset-1">
							<div class="row">
								<div class="col-lg-4">
									<?php $email = App\Settings::where('name', 'support_email')->first();?>
									<?php $phone = App\Settings::where('name', 'phone_number')->first();?>
									<h4>
										<i class="i fa fa-phone"></i>
										<span> {{ $phone == null ? '' : $phone->value }}</span>
									</h4>
									
									

									<p><a href="mailto:{{ $email == null ? '' : $email->value }}">{{ $email->value }}</a></p>
								</div>
								<div class="col-lg-4 border-right  border-left">
									<h4>MAIN</h4><br />
									<small>
										<table class = "table">
											<tr>
												<td><a href="{{ url('register') }}">Place an order</a></td>
												<td><a href="{{ route('getRules') }}">Rules</a></td>
											</tr>
											<tr>
												<td><a href="{{ route('getWriters') }}">Ratings</a></td>
												<td><a href="{{ route('getPrivacyPolicy') }}">Privacy Policy</a></td>
											</tr>
											<tr>
												<td><a href="{{ route('getRecentOrders') }}">Latest orders</a></td>
												<td><a href="{{ route('getAbout') }}">About {{ env('APP_NAME') }}</a></td>
											</tr>
										</table>
									</small></br>
								</div>
								<div class="col-lg-4">
									<h4>WRITERS AND STUDENTS</h4><br />
									<small>
										<table class="table">
											<tr>
												<td><a href="{{ url('register') }}">Become a writer</a></td>
												<td><a href="{{ route('getNoPlagiarism') }}">No plagiarism gurantee</a></td>
												
											</tr>

											<tr>
												<td><a href="{{ route('getTerms') }}">Terms and Conditions</a></td>
												<td><a href="{{ route('getFaqWriter') }}">Writers FAQ</a></td>
											</tr>

											<tr>
												<td><a href="{{ route('getFaqStudent') }}">Students FAQ</a></td>
												<td></td>
											</tr>
											
										</table>
									</small>
								</div>
							</div>
						</div>
					</div>

					<div class="row padding-tb-30 text-center">
						<div class="col-lg-12">
							<p>&copy; {{ date('Y') }} {{ env('APP_NAME') }} all rights reserved</p><br />
							<p>We accept:</p>
							<p>
								<img src="{{ asset('images/malipo.png') }}" alt="" class="img-responsive margin-horizontal" >
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		

		<script src = "{{ asset('js/bootstrap.min.js') }}"></script>
		<script src = "{{ asset('js/nicescroll.min.js') }}"></script>
		<script src = "{{ asset('js/moment.min.js') }}"></script>
		<script src = "{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
		<script src = "{{ asset('js/owl.carousel.min.js') }}"></script>
		<script src = "{{ asset('js/matchHeight-min.js') }}"></script>
		<script src = "{{ asset('js/ion.sound.min.js') }}"></script>
		
		<script src = "{{ asset('js/app.js') }}"></script>

		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
			var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
			(function(){
				var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
				s1.async=true;
				s1.src='https://embed.tawk.to/5839a7ae4160416f6d94b9a2/default';
				s1.charset='UTF-8';
				s1.setAttribute('crossorigin','*');
				s0.parentNode.insertBefore(s1,s0);
			})();

			$('.tawk-button').on('click',function(e){
	            Tawk_API.toggle();
	            e.preventDefault();
	        });
		</script>
		<!--End of Tawk.to Script-->
		
	</body>
</html>
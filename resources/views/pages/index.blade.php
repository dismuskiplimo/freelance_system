@extends('layouts.app')

@section('title', 'Home')

@section('content')
	<div class="container-fluid">
		<div class="row" style = "margin-top: -50px">

			<div class="col-lg-6">
				<div class="row student padding-t-50">
					<div class="col-lg-5">
						<img src="images/student.png" class = "img-responsive" alt="">
					</div>

					<div class="col-lg-6 white-text text-right">
						<p>STUDENT PLACES AN ORDER <i class ="fa fa-chevron-right"></i></p><br /><br />
						<p>STUDENT HIRES A WRITER <i class ="fa fa-chevron-right"></i></p><br /><br /><br />
						<p><a href = "{{ url('login') }}" class = "btn btn-success pull-right">PLACE AN ORDER</a></p>
					</div>
					
				</div>
			</div>

			<div class="col-lg-6">
				<div class="row teacher padding-t-50">
					<div class="col-lg-6 col-lg-offset-1 white-text">
						<br /><br /><p><i class ="fa fa-chevron-left"></i> WRITERS MAKE THEIR OFFERS</p><br /><br />
						<p><i class ="fa fa-chevron-left"></i> THE WRITER GETS TO WORK</p><br />
						<p><a href = "{{ url('/register') }}" class = "btn btn-primary">BECOME A WRITER</a></p>
					</div>

					<div class="col-lg-5">
						<img src="images/teacher.png" class="img-responsive" alt="">
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="container-fluid">
		<div class="row border-bottom">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 col-lg-offset-1">
						<div class="row margin-tb-80">
							<div class="col-lg-4 icon-box">
								<i class="li li_search"></i>
								<h4>Plagiarism free</h4>
								<p>We use anti-plagiarism software to ensure you get high-quality, unique papers.</p>
							</div>
							<div class="col-lg-4 icon-box center">
								<i class="li li_banknote"></i>
								<h4>Money back guarantee</h4>
								<p>We offer a limited warranty, including free revisions, and the rights to request a refund.</p>
							</div>
							<div class="col-lg-4 icon-box">
								<i class="li li_lock"></i>
								<h4>Privacy and security</h4>
								<p>We use an SSL 128 Bit encryption to protect your personal info and payment details. Your privacy is safe with us.</p>
							</div>

							<div class="col-lg-12 text-center">
								<br /><h4>WE ACCEPT</h4><br />
								<img src="images/malipo.png" alt="" style = "margin:0 auto" class="img-responsive">
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 col-lg-offset-1">
						<h1 class = "text-center">You can order from us the following</h1>
						<h4 class = "text-center">
							<small>Our website works with the best professional writers in the field. You can find an assistant for any academic task on {{ env('APP_NAME') }}!</small>
						</h4>
					</div>

					<div class="col-lg-10 col-lg-offset-1 margin-tb-40">
						<div class="row">
							@if(count($assignment_types_min))
								@foreach($assignment_types_min as $assignment)
									<div class="col-lg-4">
										<div class="assignment-type">
											<div class="icon">
												<span class="initial">{{ $assignment->name[0] }}</span>
												
											</div>
											<div class="description">
												<p class="title"><strong>{{ \Illuminate\Support\Str::limit($assignment->name, 21) }}</strong></p>
												<p class="price"><strong> ${{ $assignment->price }} / page</strong></p>
												<p class="time">within {{ $assignment->min_duration }} hours</p>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						
						</div>
					</div>
				</div>
						
			</div>
		</div>

		<div class="row border-bottom text-center padding-b-30">
			<p style = "margin-top: -30px">Or any other <a href = "" data-toggle="modal" data-target="#assignment-type-modal">Type</a></p>
		</div>

		<div class="row">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 col-lg-offset-1 padding-tb-30 text-center">
						<h3>Best price for academic papers! <button class="btn btn-primary btn-lg" type = "button" data-toggle="modal" data-target="#calculator-modal"><i class = "fa fa-calculator"></i> Price Calculator</button/></h3>
					</div>
				</div>
			</div>
		</div>

		<div class="row writer-reviews">
			<div class="container padding-tb-50">
				<div class="col-lg-10 col-lg-offset-1">
					@if(count(App\User::where('user_type', 'WRITER')->get()))
						<h1>Best writers <small><a href="{{ route('getWriters') }}">all writers</a></small> <span class = "pull-right">{{ number_format(count(App\User::where('user_type', 'WRITER')->where('active','1')->get())) }} <small>Writers</small></span></h1>
						<div class="text-center padding-tb-30 owl-carousel border-bottom" style = "margin:0 auto" id = "best-writers">
							@foreach(App\User::where('user_type', 'WRITER')->orderBy('orders_complete','DESC')->where('active','1')->take(12)->get() as $user)
							<div class="thumbnail">
								<img src="{{ $user->image ? asset('images/uploads/' . $user->image) : asset('images/new-user.png') }}" alt="" class="img-responsive">
									<div class="caption">
										<p class = "name theme-color"><strong><a href = "{{ route('getGuestWriter',['slug'=>$user->username]) }}">{{ $user->username }}</a></strong></p>
										

										<?php
											if($count = count($user->ratings)){
									            $stars = $user->ratings()->sum('stars');
									            $stars = $stars / $count;
									        }else{
									            $stars = 0;
								        }?>
    									
										<p class = "text-warning">
											@if(round($stars,1) > 0)
												@for($count = 0; $count <= round($stars,1); $count++)
													<i class="fa fa-star text-warning"></i>
												@endfor
											@endif
										</p>
										<p class = "subject">Writing</p>
										<p class = "border-bottom">&nbsp;</p>
										<h4>{{ number_format($user->orders_complete) }} <br /><small>Orders complete</small></h4>
									</div>
								
								
							</div>
							@endforeach
						@endif
						
					</div>

					<?php $reviews = App\Rating::orderBy('created_at','DESC')->take(12)->get();?>
					@if(count($reviews))
						<div class="row">
							<div class="col-lg-12 padding-tb-30">
								<h1>User Reviews</h1>
								<div class = "padding-tb-50">
									<div class="user-reviews text-center owl-carousel" id="user-reviews">
										@foreach($reviews as $review)
											<div class="review">
												<p class="essay-no">
													<strong>Essay #{{ $review->assignment_id }},</strong> 
													<span class="text-muted">{{ $review->assignment->discipline ? $review->assignment->discipline->name : 'Other' }}</span>
												</p>
												<div class="strike padding-tb-30">
													<span>
														@if($review->reaction == 'POSITIVE')
															<i class="fa fa-thumbs-up text-success"></i>
															Liked it
														@else
															<i class="fa fa-thumbs-down text-danger"></i>
															Did not Like it
														@endif

														
													</span> 
												</div>
												<p class = "text-muted">
													{{ $review->title }}
												</p>
											</div>
										@endforeach


									</div>
								</div>
								
							</div>
						</div>
					@endif

					<div class="row reviews text-center padding-tb-30">
						<div class="col-lg-4">
							<img src="{{ asset ('images/reviews/mmodm.png') }}" class = "img-responsive" alt="">
						</div>

						<div class="col-lg-4">
							<img src="{{ asset ('images/reviews/reviwcentre.png') }}" class = "img-responsive" alt="">
						</div>

						<div class="col-lg-4">
							<img src="{{ asset ('images/reviews/sitejabber.png') }}" class = "img-responsive" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="container">
				<div class="">
					<div class="col-lg-10 col-lg-offset-1">
						<h1 class = "text-center padding-tb-50">Why should you choose us?</h1>
						<div class="row">
							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
										<h4 class="fa fa-shield theme-color" style = "font-size:5em"></h4>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-8 col-xs-8">
										<h4><strong>QUALITY ASSURANCE</strong></h4>
										<p>All registered experts have solid experience in academic writing and have successfully passed our special competency examinations.</p>
									</div>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
										<h4 class="fa fa-rocket theme-color" style = "font-size:5em"></h4>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-8 col-xs-8">
										<h4><strong>ZERO PLAGIARISM GUARANTEE</strong></h4>
										<p>We only provide unique papers written entirely by the writer himself. You are 100% protected against plagiarism.</p>
									</div>
								</div>
							</div>
						</div>

						<div class="row padding-tb-30">
							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
										<h4 class="fa fa-money theme-color" style = "font-size:5em"></h4>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-8 col-xs-8">
										<h4><strong>LOW PRICE</strong></h4>
										<p>{{ env('APP_NAME') }} offers the lowest prices on the market. Our prices start at just $5 per page!</p>
									</div>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
										<h4 class="fa fa-users theme-color" style = "font-size:5em"></h4>
									</div>
									<div class="col-lg-9 col-md-9 col-sm-8 col-xs-8">
										<h4><strong>NO INTERMEDIARIES</strong></h4>
										<p>In ordering from us you are working directly with writers, and not overpaying intermediaries. So, you save up to 50% of the cost.</p>
									</div>
								</div>
							</div>


						</div>

						<div class="row">
							<div class="col-lg-8 col-lg-offset-2 text-center">
								
								<div class="row">
									<div class="col-lg-6 border-right">
										<h3>Contact us</h3><br />
										<div class="contact-div">
											<p>
												<strong>
													<?php $support_email = App\Settings::where('name','support_email')->first(); ?>
													<?php $phone = App\Settings::where('name','phone_number')->first(); ?>
													<a href = "mailto:{{ $support_email->value }}"><i class="fa fa-envelope"></i> {{ $support_email->value }}</a>
												</strong>
											</p><br />
											<p><i class="fa fa-phone"></i> {{ $phone->value }} </p><br />
										</div>
										<p><a href="{{ url('login') }}" class = "btn btn-success btn-lg">PLACE AN ORDER</a></p><br />
									</div>
									<div class="col-lg-6">
										<h3>Have a question?</h3><br />
										<div class="contact-div">
											<p><i class="fa fa-play-circle"></i> How does it work</p><br />
											<p><a href="{{ route('getFaqStudent') }}">Students FAQ</a></p>

											<p><a href="{{ route('getFaqWriter') }}">Wrtiers FAQ</a></p><br />
										</div>
										
										
										<p><button class = "btn btn-primary btn-lg tawk-button">CHAT NOW</button></p><br />

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row margin-tb-80">
			<div class="container">
				<div class="col-lg-10 col-lg-offset-1">
					<h1 class="text-center">Links</h1> 
				</div>
			</div>
		</div>
		
		

	</div>
			
	<div class="modal fade" id = "assignment-type-modal" tabindex="-1" role = "Dialog" aria-labelledby= "Assignment Type Modal">
		<div class="modal-dialog modal-lg" role = "document">
			<div class="modal-content">
				<div class="modal-header">
					<button type = "button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="row small-font">
						@if(count($assignment_types))
							@foreach($assignment_types as $assignment)
								<div class="col-lg-4">
									<div class="assignment-type">
										<div class="icon">
											<span class="initial">{{ $assignment->name[0] }}</span>
											
										</div>
										<div class="description">
											<p class="title"><strong>{{ $assignment->name }}</strong></p>
											<p class="price"><strong> ${{ $assignment->price }} / page</strong></p>
											<p class="time">within {{ $assignment->min_duration }} hours</p>
										</div>
									</div>
								</div>
							@endforeach
						@endif

					</div>
				</div>

			</div>
		</div>
	</div>
	
@endsection

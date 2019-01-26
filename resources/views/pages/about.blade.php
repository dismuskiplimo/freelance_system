@extends('layouts.app')

@section('title', 'About')

@section('content')
	<div class="container-fluid">
	    <div class="row page-header">
	        <h2>{{ env('APP_NAME') }} — online academic exchange platform<br />
	            <small>Through us you can order an Essay, Term Paper, Dissertation, or other works!</small>
	        </h2>   
	    </div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2 fullscreen">
				<h4>About our Project</h4><br>


				<p>{{ env('APP_NAME') }} is an online academic exchange platform for those who need Term Papers, 
				Essays, Thesis Papers, Dissertations, and other academic works. 
				You can search for assignments yourself. Students and Writers can communicate 
				directly, without intermediaries.</p>

				<p>Every day we have thousands of new orders in all academic disciplines and 
				sciences. All the work on {{ env('APP_NAME') }} happens online: users can discuss the
				specifics of their assignment in their personal chat. This substantially 
				helps to lower the cost of the assignment.</p>
				
				<?php $duration = App\Settings::where('name', 'mature_duration')->first();?>
				<p>The basic principle of {{ env('APP_NAME') }} is to provide the highest quality of work in 
				the shortest amount of time, and with minimal costs. We provide {{ $duration == null ? '20' : $duration->value }}-day warranty 
				for students to check and review their works. Only after the assignment is 
				accepted by the Student, the Writer will be able to collect payment. In addition 
				to the Student checking the quality of the assignment, the assignment 
				is also tested for originality in anti-plagiarism software.</p>

				<p>We offer fast and simple solutions when making payments or withdrawing 
				funds. We use payment systems such as: PayPal, Payoneer etc. This is done 
				for your convenience and for the safety of your funds.</p>


			</div>
			
		</div>
	</div>
	
@endsection

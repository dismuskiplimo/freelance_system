@extends('layouts.app')

@section('title', 'Rules')

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
				<h4>Rules</h4><br>	

				<p>Work in our system is simple and convenient. All you need to do is to follow a few rules:</p>

			    <ol class = "spaced">
			    	<li>When filling out the questionnaire, the Writer must indicate only true and reliable 
			    		information. If the contact information is incorrect or untrue, the profile will be blocked.</li>
			    	
			    	<li>Communication between Writers and Students may only happen on the pages of {{ env('APP_NAME') }}.</li>
			    	<li>Do not exchange contact information (e-mail address, Skype id, phone numbers, etc.). 
					    If there are any such attempts of contact information being transferred, the 
					    administration will block the user's account.</li>
			    	<li>Student can download the finished work on the website on in the section "My Orders" 
			    		or on the order page.</li>
			    	<li>In carrying out an order, a Writer must comply with the time limits and provide the
			    		assignment in accordance with the Student's instructions. </li>
			    	<li>Students and Writers are able to chat on the assignment pages for one month after the assignment has been closed.</li>
			    	<li>Our Service reserves rights to terminate the partnership between the Writer and the Service, 
					    if the Writer refuses to cooperate with the Service, ignores the requirements of the 
					    Student or an Administrator, does not carry out corrections for the Student, delays 
					    assignments and breaks the deadlines, allows plagiarism, or is inactive for more than 6 months.</li>
			    	<li>In situations, where the Writer has made a financial or reputational damage, 
					    the Students may place these Writers in their blacklists. 
					    This is possible when the Writer has repeatedly violated rules, or the Student's 
					    instructions and/or the rules administered by the Service Administration;
					    broke the assignment deadlines, and refused to make correction (within 3 days); 
					    or provided assignments with high plagiarism rate. If a Writer has systematically 
					    violated the rules and provided substandard work, the Administration has the rights 
					    to reset the rating of the Writer, or block their account.</li>
			    	<li>The Writers are strictly forbidden to use exceptionally internet-portals as their 
			    		source of work to substitute other literature. </li>
			    	<li>It is also forbidden to use any services offering academic services and/or completed 
					    assignments. E-books and company websites can constitute no more than 30% of all sources
					     in the assignment.</li>
			    	<li>Payments (withdrawal of funds from a personal account) are processed by the Administration 
					    manually on weekdays during working hours. After payment fees are transferred, 
					    the transfer of copyright for the work is also conducted. This prohibits the Writer 
					    to claim or publicize authorship of the assignment.</li>
			    	<li>The final version of the assignment should be uploaded in the format requested by 
					    the Student, following all the instructions and the requirements of the Student.
					    If the Student has requested a refund for the work of inappropriate quality, our 
					    Service undertakes the privileges to provide the Writer with the requirements. 
					    In case, if the situation cannot be resolved by mutual agreement, the service may 
					    involve independent experts to measure the quality of the assignment performed by 
					    the Writer (the dispute of a situation can take up to 5 working days).</li>
			    	<li><p>A 100% refund for the Student is made in the following cases:</p>
						<ul>
							<li>The Writer does not upload the final version of the assignment before the deadline.</li>
							<li>There are technical means of plagiarism deception (for example, the use of synonymizing or invisible characters).</li>
							<li>The work has not been carried out for the correct topic set by the Student (if such is stated, then the Student is required to give an explanation and give specific examples).</li>
							
						</ul>
						<p>A partial refund (up to 90%) is given to the Student if a Writer uploads the assignment, but refuses to provide requested corrections (the Student must explain, what percentage of work has not been completed by the Writer).</p>
						<p>After consideration of the complaint and making a decision on a refund to the Student, Administration shall refund the money to Student within 10 working days.</p>
						<p>The Administration has a right to decline a Student’s request for a refund if he or she didn’t request any corrections, before demanding a refund. If the Writer is consistently online, and is ready to make corrections, the Student must send the work for adjustments at least once.</p>
					</li>
			    	<li>The Administration is the final seller and appears responsible for a refund to the customer.</li>
			    	<li>If there are any disputes about the quality of the assignment, all payments will be suspended until the dispute is resolved.</li>
			    	<li>The Service has the right to use punitive sanctions on the Writers if they violate deadlines, have inconsistencies in the completed assignment, or not following the instructions provided by the Student.</li>
			    	<li>The Writer must confirm the start of work on the assignment within a specific period of time, or the assignment will be returned to the auction. In this case, the Writer's rating will be reduced. Users may only pay for the assignments using the options provided by http://{{ env('APP_NAME') }}.com . Do not conduct an exchange of payments outside the site (online wallets, bank cards, mobile phones, etc.). The identification of such attempts to exchange contacts, will force the administration to block users’ accounts and disclaim any warranty obligations on orders.</li>
			    </ol>
			    <p>By working on {{ env('APP_NAME') }}, you hereby confirm that you are familiar with the rules of the Service.</p><br>
			    
			</div>
			
		</div>
	</div>
	
@endsection

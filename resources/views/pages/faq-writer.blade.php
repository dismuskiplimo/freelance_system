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
				<h4>Writers FAQ</h4><br>

				<p>Pros of working with {{ env('APP_NAME') }}:</p>

				<p>Online Academic Exchange Platform {{ env('APP_NAME') }} allows you to work with Students directly, without overpaying intermediaries. You can set the prices for your work yourself. Your rating will rise as you complete more assignments, and as long as the quality of your works is good, your income will increase as well!</p>
				
				<br><p><strong>1. Registration and Accreditation</strong></p>

				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseOne" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								I want to work as a Writer
							</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<p>Firstly, you must complete the registration. Secondly, fill the profile section with your personal information. A request for accreditation will be formed, and you'll have to wait until the Administration approves your request. Then you'll be granted full access to our order database.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseTwo" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								Which country are you based in?
							</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<p>We are not an agency – we only do the platform maintenance so that Students and Writers can reliably communicate. You don’t need to visit our office because all work is conducted online.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseThree" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								I want to work as a Writer
							</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	

								<p>Register here:  <a href="http://gradestap.com/register/">http://gradestap.com/register/</a>
</p>
								<p>We require high qualifications from our writers. This also means that all your personal details must be authentic: your name, telephone number, degree level, and your date of birth.
</p>
								<p>To gain access to order database and placing bids, after your register, you must pass the accreditation. It's a small test which confirms that you are familiar with rules of conduct on {{ env('APP_NAME') }}. If you have any questions – you can contact our Service Support. 
								</p>

								<p>After you pass the test, don’t forget to fill out your qualifications in your Profile and Settings sections.
</p>
							</div>
						</div>
					</div>

					<br><p><strong>2. Working on an order</strong></p>
					
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFour">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseFour" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I search for orders?
							</a>
							</h4>
						</div>
						<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	

								

								<p>To search an order you need to enter title keywords and specify the discipline and type of paper. Tick the option “Without Bids” to view all the orders that currently have no bids.
</p>
								<p>Filter by price and deadline to narrow down the search results:
</p>
							    <p>Click on the price to narrow down the search results based on Student's budget</p>
							    <p>Click on the deadline to narrow down the search results based on Student's specified due date.
       </p>
    

							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFive">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseFive" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I get more information about the orders?
							</a>
							</h4>
						</div>
						<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>All Information regarding orders will be sent to your email 3 times a day (9 AM, 3 PM and 9 PM, +3GMT). We'll send you a list of new orders based on the information in your profile (disciplines and paper types). You can change the subscription options in your profile settings.
</p>
								<p>You can see the complete list of orders by clicking the Assignment Search button.
   							</p></div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingSix">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseSix" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I upload a completed assignment?
							</a>
							</h4>
						</div>
						<div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>You need to click the 'Attach File' button, located in your comments section, below the assignment specification.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingSeven">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseSeven" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I abandon an order?
							</a>
							</h4>
						</div>
						<div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>To abandon an order, send an email to <a href="mailto:support@gradestap.com">support@gradestap.com</a> with your assignment ID, and your reasons for abandoning the assignment.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingEight">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseEight" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I make a bid?
							</a>
							</h4>
						</div>
						<div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>Go to an order you are interested in and click on Place a Bid button located on the assignment page. Enter the price you're willing to work for and any comments in corresponding fields.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingNine">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseNine" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I hide my bid?
							</a>
							</h4>
						</div>
						<div id="collapseNine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>The bids are hidden automatically from all other Writers and are visible only to Students.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTen">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseTen" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I leave comments?
							</a>
							</h4>
						</div>
						<div id="collapseTen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>To leave comments, you must first place your bid. After you have placed a bid, you can leave comments for the Student below the assignment info.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingEleven">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseEleven" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								When do I receive payment for a completed assignment?
							</a>
							</h4>
						</div>
						<div id="collapseEleven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>The Student makes pays for an assignment when choosing a Writer. The money will be put on Hold, on their account balance until the final version of the assignment is uploaded. After it has been uploaded, the 20-day warranty begins. During the warranty period, the Student can make requests for corrections, and the Writer is obligated to correct and improve the assignment. A Student's request for correction must still be within the assignment specifications. After 20-day warranty period, the withheld funds will be transferred to the Writer's account.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwelve">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseTwelve" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I withdraw funds?
							</a>
							</h4>
						</div>
						<div id="collapseTwelve" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>You can withdraw your funds using one of the following methods: Paypal, Payoneer, or a direct transfer onto your bank card. You can choose your method when you make your first withdrawal request.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThirteen">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseThirteen" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How long does it take to withdraw funds?
							</a>
							</h4>
						</div>
						<div id="collapseThirteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>Requests for withdrawals are processed after 3 working days have passed since the filling of the requests. After approval, the requests are filed to the payment system of your choice to finalize the transaction.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingForteen">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseForteen" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How much is the commission?
							</a>
							</h4>
						</div>
						<div id="collapseForteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>18% Commissio for both student and writer</p>
							</div>
						</div>
					</div>

					<br><p><strong>3. Problems</strong></p>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFifteen">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseFifteen" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								A Student has left a poor review
							</a>
							</h4>
						</div>
						<div id="collapseFifteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>You can petition a review in the Reviews section of your profile screen. If a review is false or offensive, the Administration may edit or delete it.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingSixteen">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseSixteen" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How long does it take for the Administration to process a petitioned review?
							</a>
							</h4>
						</div>
						<div id="collapseSixteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>The petitions may be processed for up to five working days.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingSeventeen">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseSeventeen" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I make a complaint against a Student?
							</a>
							</h4>
						</div>
						<div id="collapseSeventeen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>Send your assignment ID and the description of your problem to <a href="mailto:support@gradestap.com">support@gradestap.com</a></p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingEighteen">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseEighteen" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								I am not satisfied with the result of a complaint
							</a>
							</h4>
						</div>
						<div id="collapseEighteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>If you are not satisfied with a refund, to send an email to <a href="mailto:support@gradestap.com">support@gradestap.com</a> and give legitimate reasons to why you do not agree.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingNineteen">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseNineteen" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How long does it take to process a complaint?
							</a>
							</h4>
						</div>
						<div id="collapseNineteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>The Requests for refunds and recalculations are processed by the Administration in up to five working days depending on the complexity.</p>	
							</div>
						</div>
					</div>

					<br><p><strong>4. Writer</strong></p>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwenty">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseTwenty" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How to take on an assignment from the auction?
							</a>
							</h4>
						</div>
						<div id="collapseTwenty" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								<p>You must place a Bid: open the assignment page and click 'Place a bid' button.</p>	
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwentyOne">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseTwentyOne" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I learn I have been chosen as the Writer for an assignment?
							</a>
							</h4>
						</div>
						<div id="collapseTwentyOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								

								<p>If you have been selected as a Writer, you will receive a notification by email. You will have to confirm that you're willing to start working and will complete the assignment within deadline. The order status will then change to 'In Progress'.
</p>
								<p>If you opt out of work or do not confirm it within 12 hour period, the assignment will automatically return to the auction.
	</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwentyTwo">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseTwentyTwo" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								What can I do to get more assignments?
							</a>
							</h4>
						</div>
						<div id="collapseTwentyTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">	
								


							<p>In order to get more orders and to become a successful Writer, you can take a few simple steps:
</p>
							<ul>
								<li>Please provide your portfolio. Fill your profile to ensure that the Student has information about your professionalism and qualifications.
							   </li>

								<li>Improve your rating. Please remember that the rating is not only given on the basis of completed orders (earned money), but also on the basis of Student feedback, therefore, try to provide better papers in due time. This will help you build your reputation on {{ env('APP_NAME') }}
							    </li>

								<li>Place more Bids. If customers tend not to immediately choose you, try lowering your prices;
							    </li>

								<li>Please explain why you're the perfect Writer for the assignment. In addition to giving your price be sure to write a comment on why the Student should choose you.
							    </li>

								<li>Work with enthusiasm, pay attention to details. Place all the instructions carefully and plan your writing together with a Student.
							    </li>
								<li>Do the assignment efficiently and respond to the Student’s questions quickly. Do not ignore Students trying to contact you.
							   </li>
								<li>Configure your automated notifications. You can set up automated newsletters in your profile. These newsletters will tell you about the new orders that suit your quialifications. The newsletters are delivered to your address three times a day.
							    </li>
								<li>Perseverance will help you find a good assignment. Even if a Student didn’t choose you, don't give up - every day hundreds of different Students place new orders.

</li>
							</ul>
							     

							</div>
						</div>
					</div>

				</div>

			</div>
			
		</div>
	</div>
	
@endsection

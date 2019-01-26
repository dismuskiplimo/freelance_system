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
				<h4>Students FAQ</h4><br>

				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseOne" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								Why should you use our services?
							</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<p>{{ env('APP_NAME') }} is an online exchange service, NOT an agency! 
								Writers and Students work together directly, without 
								having to deal with intermediaries. This allows for 
								lesser assignment costs. Chat directly on our website
								 – solve any issues with your Student of Writer right
								  away!</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseTwo" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How to place an order?
							</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								

								<p>If a Student hasn’t signed up on our website yet, he or she can place an order by first registering at as a student
</p>
								<p>When placing an order, it is necessary to provide the title, citation format, and the discipline.
</p>
								<p>If you cannot find your Discipline in our list – choose the most similar one.
</p>
								<p>Make sure you give instructions for your assignment, and attach all necessary files to it (for example any material handed out by your professor).
</p>
								<p>Give a Due Date deadline for the assignment (the day is completed on 11:59PM UTC/GMT -3 Moscow). If the order is urgent and requires to be completed within a few hours – input the exact time of completion.
</p>
								<p>You can specify your budget - the amount you’re willing to spend on the assignment, and then wait for offers from our Writers.
</p>
								<p></p>You can attach any types of files limited by size of 15mb. If there are any problems with file attachments, you can upload them in an archive.

							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseThree" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I make a payment?
							</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<p>In order to make a payment, you have to deposit funds into your virtual {{ env('APP_NAME') }} Wallet (to your account). You can accomplish this using different payment methods, including bank cards, electronic money, PayPal, Webmoney, etc.
							</p></div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFour">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseFour" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How do I choose a Writer?
							</a>
							</h4>
						</div>
						<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<p>After you have placed your order, you can choose a Writer based on their rating or their offered price. You must click “Choose Writer”, once pressed – you’ll have to pay for your order.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingFive">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseFive" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								Deadlines
							</a>
							</h4>
						</div>
						<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<p>The Due Date of an assignment is specified by the Student during the order placement. It is also possible to make an urgent order (completion in the near 24 hour period).</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingSix">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseSix" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								How much does it cost?
							</a>
							</h4>
						</div>
						<div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<p>Because there are no intermediaries, costs for assignments are minimal. To get your prices for an assignment directly from the writers you have to place an order to the Auction and wait for Bids from our Writers.</p>
							</div>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingSeven">
							<h4 class="panel-title">
							<a role="button" class = "btn-block" href="#collapseSeven" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
								Guarantee
							</a>
							</h4>
						</div>
						<div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								

								<p><strong>Guarantee of funds:</strong></p>

								<p>When you add funds onto your account on {{ env('APP_NAME') }}, you will have those funds available at all times. Funds are secured by E-Money and Platron. If you need your funds to be returned to you, you can do it easily in your account in the Withdraw section.
</p>
								<p>{{ env('APP_NAME') }} guarantees the safety of your funds when paying for assignments. Payments are made as 100% immediately. When the payment transfer has been made (when you chose your Writer) the funds are put on Hold.
</p>
								<p>Writer receives his earned money only after he uploads the assignment, which meets full requirements of the Student and the 20-day Warranty has expired. If the Writer does not complete his work, the money will be returned to the Student, and he may chose a different Writer for the completion of the assignment.
</p>
								<p><strong>Guarantee of quality:</strong></p>

								<p>The quality of an assignment is measured with text originality in anti-plagiarism systems, as well as in accordance with the instructions of the Student (completed by following directions of the assignment and by the due date). If the assignment is completed with errors or inaccuracies, the Student may send it in for a free revision to the Writer. If the problem hadn’t been solved, the Student may request a full or partial refund.
</p>
							</div>
						</div>
					</div>

					


				</div>


				

			</div>
			
		</div>
	</div>
	
@endsection

@extends('layouts.app')

@section('title', 'No plagiarism gurantee')

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
				<h4>No plagiarism guarantee</h4><br>
				<p>At {{ env('APP_NAME') }}.com, we check each paper for plagiarism before returning it to our customers in order to be sure of the originality of our writers' work. Each paper is checked for uniqueness using specially designed plagiarism detection software. We constantly upgrade this software to make certain it provides the most reliable results. Because of this, as a reputable academic assistance company, we guarantee each piece of writing is free of plagiarism against on-line based sources, all sample- or free-paper databases, and all work ever checked by our own software.</p>
				<p>If you have any doubt regarding the originality of the piece you receive from our company, we are glad to investigate the issue and revise the suspect content free of charge. In the case of a dispute due to plagiarism detected in a paper our writer has completed, we only accept a scanned version of the plagiarism report from either turnitin.com itself, or your professor or university. No other document can serve as valid proof that the paper is plagiarized.</p>
				<p>With good reason, {{ env('APP_NAME') }}.com has earned the reputation of a reliable and trustworthy company. Our repeat customers are the best proof that {{ env('APP_NAME') }}.com is a top-quality writing service to which it is possible to entrust one's academic career. You can be sure that our Plagiarism-Free Guarantee is not something we would jeopardize by putting our customers trust and loyalty at risk.</p>
			</div>
			
		</div>
	</div>
	
@endsection

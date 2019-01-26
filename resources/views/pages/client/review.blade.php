@extends('layouts.client')

@section('title', 'Review ' . $writer->username)

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h4>Rate {{ $writer->username }} for the assignment, "{{ $assignment->title }}"</h4> <br/>
				<div class="card">
					<form action="{{ route('postCreateReview',['assignment_id' => $assignment->id , 'writer_id' => $writer->id ]) }}" method = "POST">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="">Summary (required)</label>
							<input type="text" name = "title" class="form-control" required />
						</div>

						<div class="form-group">
							<label for="">Details (optional)</label>
							<textarea name="content" id="" rows="4" class="form-control"></textarea>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">How was your experience with {{ $writer->username }} ?</label>
									<div class="radio">
										<label for="positive-reaction" class = "radio-inline text-success">
											<input type="radio" name = "reaction" id = "positive-reaction" value = "POSITIVE" checked="checked"> Good <i class="fa fa-thumbs-up"></i>
										</label>

										<label for="negative-reaction" class = "radio-inline text-danger">
											<input type="radio" name = "reaction" id = "negative-reaction" value = "NEGATIVE"> Bad <i class="fa fa-thumbs-down"></i>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Rating</label>

									<div class="radio">
										<label for="one-star" class = "radio-inline text-warning">
											<input type="radio" name = "stars" id = "one-star" value = "1"> <i class="fa fa-star"></i>
										</label>

										<label for="two-stars" class = "radio-inline text-warning">
											<input type="radio" name = "stars" id = "two-stars" value = "2"> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
										</label>

										<label for="three-stars" class = "radio-inline text-warning">
											<input type="radio" name = "stars" id = "three-stars" value = "3"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
										</label>

										<label for="four-stars" class = "radio-inline text-warning">
											<input type="radio" name = "stars" id = "four-stars" value = "4"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
										</label>

										<label for="five-stars" class = "radio-inline text-warning">
											<input type="radio" name = "stars" id = "five-stars" value = "5" checked="checked"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
										</label>
									</div>

								</div>
							</div>
						</div>	

						<div class="form-group">
							<button type = "submit" class="btn btn-success">Rate writer</button>
							<a href="{{ route('getClientOrders') }}" class="btn btn-warning pull-right">Skip review</a>
						</div>					
					</form>
				</div>

			</div>
		</div>
	</div>
@endsection
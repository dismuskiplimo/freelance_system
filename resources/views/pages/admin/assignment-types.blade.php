@extends('layouts.admin')

@section('title', 'Assignment Types')

@section('content')

	@include('includes.admin.assignments-nav')
	<div class="row">
		<div class="col-sm-4">
			<h4>Add new assignment type</h4>
			<form action="{{ route('postAdminAssignmentTypes') }}" method = "POST">
				{{ csrf_field() }}
				<div class="hidden-xs" style = "margin-top:45px"></div>
				<div class="form-group">
					<label for="">Assignment Type</label>
					<input type="text" class="form-control required" name = "name" required />
				</div>

				<div class="form-group">
					<button type = "submit" class="btn btn-success"><i class="fa fa-plus"></i> Add Assignment Type</button>
				</div>
			</form>
		</div>

		<div class="col-sm-8">
			<h4>Current Assignment Types ({{ $assignment_types->total() }})</h4>
			@if(count($assignment_types))
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Assignment Type</th>
							<th>Created</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($assignment_types as $assignment_type)
							<tr>
								<td>{{ $assignment_type->name }}</td>
								<td>{{ $assignment_type->created_at }}</td>
								<td>
									<a href="" class="btn btn-sm btn-info" data-toggle = "modal" data-target = "#edit-modal-{{ $assignment_type->id }}"><i class="fa fa-edit"></i></a>
									<!-- Modal -->
									<div class="modal fade" id="edit-modal-{{ $assignment_type->id }}">
										<div class="modal-dialog" role="document">
											<form action="{{ route('updateAdminAssignmentTypes',['id' => $assignment_type->id]) }}" method = "POST">
												
												<div class="modal-content">
													
													{{ csrf_field() }}
													<input type="hidden" name = "_method" value = "PATCH" />
													
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="myModalLabel">Edit Assignment Type</h4>
													</div>
													<div class="modal-body">
														<div class="form-group">
															<label for="">Assignment Type</label>
															<input type="text" value = "{{ $assignment_type->name }}" name = "name" class="form-control" required />
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button type="submit"  class="btn btn-primary pull-right">Save changes</button>
													</div>
													
												</div>
											</form>
										</div>
									</div>
								</td>
								<td>
									<form action="{{ route('deleteAdminAssignmentTypes',['id' => $assignment_type->id]) }}" method = "POST">
										{{ csrf_field() }}
										<input type="hidden" name = "_method" value = "DELETE" />
										<button type = "submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
									</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{{ $assignment_types->links() }}
			@endif
		</div>
	</div>
    
@endsection
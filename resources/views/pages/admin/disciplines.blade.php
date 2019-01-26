@extends('layouts.admin')

@section('title', 'Disciplines')

@section('content')

	@include('includes.admin.assignments-nav')
	<div class="row">
		<div class="col-sm-4">
			<h4>Add new discipline</h4>
			<form action="{{ route('postAdminDisciplines') }}" method = "POST">
				{{ csrf_field() }}
				<div class="hidden-xs" style = "margin-top:45px"></div>
				<div class="form-group">
					<label for="">Discipline</label>
					<input type="text" class="form-control required" name = "name" required />
				</div>

				<div class="form-group">
					<button type = "submit" class="btn btn-success"><i class="fa fa-plus"></i> Add discipline</button>
				</div>
			</form>
		</div>

		<div class="col-sm-8">
			<h4>Current disciplines ({{ $disciplines->total() }})</h4>
			@if(count($disciplines))
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Discipline</th>
							<th>Created</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($disciplines as $discipline)
							<tr>
								<td>{{ $discipline->name }}</td>
								<td>{{ $discipline->created_at }}</td>
								<td>
									<a href="" class="btn btn-sm btn-info" data-toggle = "modal" data-target = "#edit-modal-{{ $discipline->id }}"><i class="fa fa-edit"></i></a>
									<!-- Modal -->
									<div class="modal fade" id="edit-modal-{{ $discipline->id }}">
										<div class="modal-dialog" role="document">
											<form action="{{ route('updateAdminDisciplines',['id' => $discipline->id]) }}" method = "POST">
												
												<div class="modal-content">
													
													{{ csrf_field() }}
													<input type="hidden" name = "_method" value = "PATCH" />
													
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="myModalLabel">Edit discipline</h4>
													</div>
													<div class="modal-body">
														<div class="form-group">
															<label for="">Discipline</label>
															<input type="text" value = "{{ $discipline->name }}" name = "name" class="form-control" required />
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
									<form action="{{ route('deleteAdminDisciplines',['id' => $discipline->id]) }}" method = "POST">
										{{ csrf_field() }}
										<input type="hidden" name = "_method" value = "DELETE" />
										<button type = "submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
									</form>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{{ $disciplines->links() }}
			@endif
		</div>
	</div>
    
@endsection
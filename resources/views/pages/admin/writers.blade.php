@extends('layouts.admin')

@section('title', 'Writers')

@section('content')

@include('includes.admin.writers-nav')

<div class="row">
		<div class="col-xs-12">
			@if(count($users))
				<div class="card">
				<table class="table table-responsive table-striped">
					<thead>
						<tr>
							<th>Username</th>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Country</th>
							<th>DOB</th>
							<th>Balance</th>
							<th>Last seen</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
						@foreach($users as $user)
							<tr>
								<td><a href="{{ route('getAdminUser',['id'=>$user->id]) }}">{{ $user->username }}</a></td>
								<td><a href="{{ route('getAdminUser',['id'=>$user->id]) }}">{{ $user->name }}</a></td>
								<td><a href="{{ route('getAdminUser',['id'=>$user->id]) }}">{{ $user->email }}</a></td>
								<td>{{ $user->phone }}</td>
								<td>{{ $user->country ? $user->country->country_name : '' }}</td>
								<td>{{ $user->dob }}</td>
								<td>${{ number_format($user->balance,2) }}</td>
								<td>{{ $user->last_seen }}</td>
								<td>
									@if($user->active == 1)
										<form action="{{ route('postDeactivateUser',['id'=>$user->id]) }}" method = "POST">
											{{ csrf_field() }}
											<button type = "submit" class="btn btn-sm btn-danger">Deactivate</button>
										</form>
									@else
										<form action="{{ route('postActivateUser',['id'=>$user->id]) }}" method = "POST">
											{{ csrf_field() }}
											<button type = "submit" class="btn btn-sm btn-success">Activate</button>
										</form>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{{ $users->links() }}
				</div>
			@endif
		</div>

	</div>
    
@endsection
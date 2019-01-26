<div class="card">
	<img src="{{ empty($user->image) ? asset('images/new-user.png') : asset('images/uploads/'.$user->image) }}" class = "img-full margin-b-20 img-responsive" alt="{{ $user->name }}">
	<small>
		<strong>
			<p>Completed <span class="pull-right">{{ number_format($user->orders_complete) }}</span></p>
			<p>Working now <span class="pull-right">{{ count($user->orders_assigned()->where('status','PROGRESS')->get()) }}</span></p>
		</strong>

		<hr>

		@if(count($user->my_assignment_types))
			<strong><p>Types of work</p></strong>
			<ul class="text-muted">
				@foreach($user->my_assignment_types as $assignment_type)
					<li>{{ $assignment_type->assignment_type ? $assignment_type->assignment_type->name : "Other" }}</li>
				@endforeach
			</ul>
			
			
			<hr>
		@endif
		
		@if(count($user->my_disciplines))
			<strong><p>Topics</p></strong>
			<ul class="text-muted">
				@foreach($user->my_disciplines as $my_discipline)
					<li>{{ $my_discipline->discipline ? $my_discipline->discipline->name : "Other" }}</li>
				@endforeach
			</ul>
			
			
			<hr>
		@endif

		<table class="full-width">
			<tr>
				<td><i class="fa fa-eye medium-size"></i></td>
				<td>Views</td>
				<td>{{ number_format($user->views) }}</td>
			</tr>
		</table>
	</small>
	

</div>
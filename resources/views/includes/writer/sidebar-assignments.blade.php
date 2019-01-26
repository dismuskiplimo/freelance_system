<div class="card">
	<h4>Recommended Assignments</h4>
	<hr>
	@if(count($orders))
		<small>
			@foreach($orders as $order)
				<div class="reccomended-assignment">
					<p>#{{ $order->id }} <span><button type = "button" class = "btn btn-danger close theme-color"> &times; </button></span></p>

					<p><a href="{{ route('getSingleWriterOrder', ['id' => $order->id]) }}"> {{ $order->title }} </a></p>
					<strong>
						<p>{{ $order->assignment_type ? $order->assignment_type->name : '' }}{{ $order->discipline ? ', '.$order->discipline->name : '' }}</p>
						<table class="full-width">
							<tr>
								<td><span class="text-muted">Price <span class="pull-right">:</span></span></td>
								<td class="text-right">{{ empty($order->price) ? 'negotiable' : '$' . number_format($order->price,2) }} </td>
							</tr>

							<tr>
								<td><span class="text-muted">Deadline <span class="pull-right">:</span></span></td>
								<td class="text-right">{{ $order->deadline->diffForHumans() }}</td>
							</tr>
						</table>
					</strong>
					<hr>
				</div>
			@endforeach
		</small>

	@endif
	
	
</div>
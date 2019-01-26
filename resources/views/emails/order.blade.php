<h4><strong>#{{ $assignment->id }} {{ $assignment->title }} Posted to Auction</strong></h4>


<P>New Order created at {{ env('APP_NAME') }}.com.</p><br>

<p><strong>{{ $assignment->title }}</strong></p><br>
<p>Assignment Type: {{ $assignment->assignment_type ? $assignment->assignment_type->name : 'Other' }}</p>
<p>Discipline: {{ $assignment->discipline ? $assignment->discipline->name : 'Other' }}, 
<small>{{ $assignment->discipline ? $assignment->discipline->name : 'Other' }}</small></p>
<p style = "color:red">Deadline: {{ $assignment->deadline }}</p>
<p>Pages/Words: {{ $assignment->pages }} Pages ({{ number_format($assignment->pages * 250) }} words)</p>
<h3 style = "color:green">Price: {{ $assignment->price ? '$ '.number_format($assignment->price,2) : 'negotiable' }}</h3>

<p>Instructions</p>
<p>{{ $assignment->instructions }}</p>

<p><a href="{{ url(route('getPublicAssignment', ['id'=>$assignment->id])) }}">View assignment</a></p>

<p>{{ env('APP_NAME') }} Team</p>






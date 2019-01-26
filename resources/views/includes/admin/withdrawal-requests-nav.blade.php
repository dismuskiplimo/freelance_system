<ul class="nav nav-pills" style="margin-bottom:30px">
	<li{!! $sub_page == 'pending_requests' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminWithdrawalRequests',['type'=>'pending']) }}">Pending</a></li>
	<li{!! $sub_page == 'complete_requests' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminWithdrawalRequests',['type'=>'complete']) }}">Completed</a></li>
	<li{!! $sub_page == 'rejected_requests' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminWithdrawalRequests',['type'=>'rejected']) }}">Rejected</a></li>
</ul>
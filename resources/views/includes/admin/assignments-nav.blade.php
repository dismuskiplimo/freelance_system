<ul class="nav nav-pills" style="margin-bottom:30px">
	<li{!! $sub_page == 'auction' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminAssignments',['type'=>'auction']) }}">Auction</a></li>
	<li{!! $sub_page == 'progress' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminAssignments',['type'=>'progress']) }}">In Progress</a></li>
	<li{!! $sub_page == 'complete' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminAssignments',['type'=>'complete']) }}">Completed</a></li>
	<li{!! $sub_page == 'rejected' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminAssignments',['type'=>'rejected']) }}">Rejected</a></li>
	<li{!! $sub_page == 'late' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminAssignments',['type'=>'late']) }}">Late</a></li>
	<li{!! $sub_page == 'expired' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminAssignments',['type'=>'expired']) }}">Expired</a></li>
	<li{!! $sub_page == 'disciplines' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminDisciplines') }}">Disciplines</a></li>
	<li{!! $sub_page == 'subjects' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminSubjects') }}">Subjects</a></li>
	<li{!! $sub_page == 'assignment_types' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminAssignmentTypes') }}">Assignment Types</a></li>
	<li{!! $sub_page == 'languages' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminLanguages') }}">Languages</a></li>
</ul>
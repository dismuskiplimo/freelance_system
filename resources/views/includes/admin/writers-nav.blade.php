<ul class="nav nav-pills" style="margin-bottom:30px">
	<li{!! $sub_page == 'active_writers' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminWriters',['type'=>'active']) }}">Active <span class = "badge pull-right" style = "background-color:red;color:white">({{ number_format(count(App\User::where('user_type','WRITER')->where('active',1)->get())) }})</span></a></li>
	<li{!! $sub_page == 'inactive_writers' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminWriters',['type'=>'inactive']) }}">Inactive <span class = "badge pull-right" style = "background-color:red;color:white">({{ number_format(count(App\User::where('user_type','WRITER')->where('active',0)->where('attempts_left','>','0')->get())) }})</span></a></li>
	<li{!! $sub_page == 'blocked_writers' ? ' class = "active"' : '' !!}><a href="{{ route('getAdminWriters',['type'=>'blocked']) }}">Blocked <span class = "badge pull-right" style = "background-color:red;color:white">({{ number_format(count(App\User::where('user_type','WRITER')->where('attempts_left',0)->get())) }})</span></a></li>
</ul>
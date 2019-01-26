<div class="sidebar nicescroll" data-background-color="white" data-active-color="danger">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ route('getAdminDashboard') }}" class="simple-text">
                    {{ env('APP_NAME') }}
                </a>
            </div>

            <ul class="nav">
                <li{!! $page == 'dashboard' ? ' class = "active"' : '' !!}>
                    <a href="{{ route('getAdminDashboard') }}">
                        <i class="ti-panel"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li{!! $page == 'withdrawal-requests' ? ' class = "active"' : '' !!}>
                    <a href="{{ route('getAdminWithdrawalRequests',['type'=>'pending']) }}">
                        <i class="ti-info-alt"></i>
                        <p>Wd Requests 

                        @if(count(App\WithdrawalRequest::where('status','PENDING')->get()))
                           <span class = "badge pull-right" style = "background-color:red;margin-top:5px">({{ number_format(count(App\WithdrawalRequest::where('status','PENDING')->get())) }})</span> 
                        @endif

                        </p>
                    </a>
                </li>

                <li{!! $page == 'writers' ? ' class = "active"' : '' !!}>
                    <a href="{{ route('getAdminWriters',['type'=>'active']) }}">
                        <i class="ti-user"></i>
                        <p>Writers</p>
                    </a>
                </li>

                <li{!! $page == 'clients' ? ' class = "active"' : '' !!}>
                    <a href="{{ route('getAdminClients',['type'=>'active']) }}">
                        <i class="ti-user"></i>
                        <p>Clients</p>
                    </a>
                </li>

                <li{!! $page == 'assignments' ? ' class = "active"' : '' !!}>
                    <a href="{{ route('getAdminAssignments',['type'=>'auction']) }}">
                        <i class="ti-book"></i>
                        <p>Assignments</p>
                    </a>
                </li>

                <li{!! $page == 'transactions' ? ' class = "active"' : '' !!}>
                    <a href="{{ route('getAdminTransactions', ['type' => 'insite', 'amount' => 'all']) }}">
                        <i class="ti-money"></i>
                        <p>Transactions</p>
                    </a>
                </li>

                <li{!! $page == 'profile' ? ' class = "active"' : '' !!}>
                    <a href="{{ route('getAdminProfile') }}">
                        <i class="ti-user"></i>
                        <p>Profile</p>
                    </a>
                </li>

                 <li{!! $page == 'settings' ? ' class = "active"' : '' !!}>
                    <a href="{{ route('getAdminSettings') }}">
                        <i class="ti-settings"></i>
                        <p>Settings</p>
                    </a>
                </li>

                <li>
                    <a href=""
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i>
                        <p>Logout</p>
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
    
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('getAdminDashboard') }}">@yield('title')</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="{{ route('getAdminDashboard') }}" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="ti-panel"></i>
								<p>Stats</p>
                            </a>
                        </li>

                       <!--  <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-bell"></i>
                                    <p class="notification">5</p>
									<p>Notifications</p>
									<b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li> -->

						<li>
                            <a href="{{ route('getAdminSettings') }}">
								<i class="ti-settings"></i>
								<p>Settings</p>
                            </a>
                        </li>

                        <li>
                            <a href=""
                                onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>

        <div class="content">

        <div class="container-fluid">

        @include('includes.messages')
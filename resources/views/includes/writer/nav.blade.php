<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" style = "margin-top:4px" href="{{ route('getClientDashboard') }}">
                <img style = "height:40px" src="{{ asset('images/logo1.png') }}" alt="{{ env('APP_NAME') }}">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class = "dropdown">
                	<a href="" class="dropdown-toggle" data-toggle="dropdown" role = "button">
                		<i class="fa fa-globe medium-size"></i> 
                        @if(count(Auth::user()->notifications()->where('to_id', Auth::user()->id)->where('read_status', 0)->get()))
                            <span class="badge notifications-count" style = "background-color:red;">{{ count(Auth::user()->notifications()->where('to_id', Auth::user()->id)->where('read_status', 0)->get()) }}</span>
                        @else
                            <span class="badge notifications-count hidden" style = "background-color:red;"></span>
                        @endif
                	</a>
					
					<ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel">

						<div class="notification-heading">
							<h4 class="menu-title">Notifications</h4>
							<a href="{{ route('getWriterNotifications') }}" class="menu-title pull-right">View all
								<i class="glyphicon glyphicon-circle-arrow-right"></i>
							</a>
						</div>
						<li class="divider"></li>
						
						
						@if(count(Auth::user()->notifications))
							<div class="notifications-wrapper">
                            @foreach(Auth::user()->notifications()->orderBy('created_at', 'DESC')->limit(10)->get() as $notification)
								
									<a class="content" href="{{ route('getWriterNotification', ['id'=>$notification->id]) }}">
										<div class="notification-item{{ $notification->read_status == 0 ? ' active' : '' }}">
											<h4 class="item-title">{!! '<strong>'. $notification->author->username. '</strong>' . ' ' . $notification->message . ', ' . $notification->updated_at->diffForHumans() !!}</h4>
											
										</div>
									</a>
								
								
							@endforeach
                            </div>
						@endif
						
					</ul>
                </li>
                <li>
                    <a href="{{ route('getWriterConversations') }}" data-toggle="tooltip" data-placement="bottom" title="Messages">
                        <i class="fa fa-envelope medium-size"></i> 
                        @if(count(Auth::user()->messages()->where('read_status', 0)->get()))
                            <span class="badge message-count" style = "background-color:red;">
                                {{ count(Auth::user()->messages()->where('to_id', Auth::user()->id)->where('read_status', 0)->get()) }}
                            </span>
                        @else
                            <span class="badge message-count hidden" style = "background-color:red;"></span>
                        @endif
                    </a>
                </li>
                <li class = "active"  style = "margin-top:3px"><a href="{{ route('getOrderSearch') }}">ASSIGNMENT SEARCH</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('getWriterBalance') }}"><i class="fa fa-money medium-size"></i> <strong>${{ number_format(Auth::user()->balance, 2) }}</strong></a></li>
                <li class = "active"  ><a href="{{ route('getWriterWithdraw') }}"> <i class="fa fa-credit-card medium-size"></i> <span style = "padding-bottom: 2px">WITHDRAW FUNDS</span></a></li>
                <!-- Authentication Links -->


                
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <img width="25px" height="25px" src="{{ empty(Auth::user()->thumbnail) ? asset('images/new-user-thumbnail.png') : asset('images/uploads/'.Auth::user()->thumbnail) }}">  <span class="fa fa-chevron-down" style = "margin-left: 20px "></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('getWriterProfile') }}">My Profile</a></li>
                        <!--<li><a href="{{ route('getWriterCommission') }}">My Commission</a></li>-->
                        <li><a href="{{ route('getWriterBalance') }}">Balance</a></li>
                        <!--<li><a href="{{ route('getWriterBlacklist') }}">Blacklist</a></li>-->

                        <li>
                            <a href="{{ url('/logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Exit
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
               
            </ul>
        </div>
    </div>
</nav>

<nav class="navbar navbar-default navbar-static-top" style = "margin-top:-21px">
    <div class="container-fluid">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-sub-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            
        </div>

        <div class="collapse navbar-collapse" id="app-sub-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ route('getWriterDashboard') }}">Home</a></li>
                <li><a href="{{ route('getOrderSearch') }}">Auction</a></li>
                <li><a href="{{ route('getWriterOrders') }}">My Orders</a></li>
                <li><a href="{{ route('getWriterBalance') }}">Balance</a></li>
                <li><a href="{{ route('getUserProfile', ['slug' => Auth::user()->username]) }}">My Profile</a></li>
                <li><a href="{{ route('getWriterQualification') }}">Settings</a></li>
            </ul>

            
        </div>
    </div>
</nav>

@include('includes.messages')
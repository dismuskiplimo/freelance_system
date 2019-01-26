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
                <li><a href="" data-toggle="tooltip" data-placement="bottom" title="Notifications"><i class="fa fa-globe medium-size"></i></a></li>
                <li><a href="" data-toggle="tooltip" data-placement="bottom" title="Messages"><i class="fa fa-envelope medium-size"></i></a></li>
                <li class = "active"  style = "margin-top:3px"><a href="">ASSIGNMENT SEARCH</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href=""><i class="fa fa-money medium-size"></i> <strong>$344</strong></a></li>
                <li class = "active"  ><a href=""> <i class="fa fa-credit-card medium-size"></i> <span style = "padding-bottom: 2px">WITHDRAW FUNDS</span></a></li>
                <!-- Authentication Links -->


                
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <img width="25px" height="25px" src="{{ asset('images/new-user-thumbnail.png') }}">  <span class="fa fa-chevron-down" style = "margin-left: 20px "></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="">My Profile</a></li>
                        <li><a href="">My Commission</a></li>
                        <li><a href="">Balance</a></li>
                        <li><a href="">Blacklist</a></li>

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
                <li><a href="">Home</a></li>
                <li><a href="">Auction</a></li>
                <li><a href="">My Orders</a></li>
                <li><a href="">Balance</a></li>
                <li><a href="">My Profile</a></li>
                <li><a href="">Settings</a></li>
            </ul>

            
        </div>
    </div>
</nav>

@include('includes.client.messages')
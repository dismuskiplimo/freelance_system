<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img style = "height:40px" src="{{ asset('images/logo1.png') }}" alt="{{ env('APP_NAME') }}">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="" data-toggle="modal" data-target="#calculator-modal"><i class="fa fa-calculator"></i> Price Calculator</a></li>

                    @if (Auth::guest())
                        <li><a href="" data-toggle="modal" data-target="#auth-modal" id = "login-link">Log in</a></li>
                        <li class = "active"><a href=""  data-toggle="modal" data-target="#auth-modal" id = "signup-link"><b>SIGN UP</b></a></li>
                    @else
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                               <img src="{{ asset('images/new-user-thumbnail.png') }}" alt="" style ="width: 25px;height: auto"> <span class="fa fa-chevron-down" style = "margin-left: 40px"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('getDashboard') }}"> <i class="fa fa-dashboard"></i> Dashboard</a></li>
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
        
    </div>
</nav>

@include('includes.messages')
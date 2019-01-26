@extends('layouts.app')

@section('title','Login')

@section('content')

<div class="container-fluid">
    <div class="row page-header">
        <h2>{{ env('APP_NAME') }} — online academic exchange platform<br />
            <small>Through us you can order an Essay, Term Paper, Dissertation, or other works!</small>
        </h2>   
    </div>
</div>

<div class="container fullscreen">
    <div class="row padding-b-50">
        
        <div class="col-md-4 col-md-offset-4">
            <h3>Login in</h3><br />
            <div class="panel panel-default shake-div">
                <div class="row padding-tb-50">
                    <div class="col-lg-10 col-lg-offset-1">
                         <form class="auth-submit" role="form" method="POST" action="{{ url('/login') }}">
                            <div class = "shake-div">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">E-Mail / Username</label>
                                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}"  autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" >

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                

                                <div class="form-group">
                                    
                                    <p class = "text-right"><a class="btn btn-link" href="{{ url('/password/reset') }}"> Forgot Your Password? </a></p><br />
                                    
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Login
                                    </button>
                                </div>

                                

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>

                                <p>Don't have an account? <a href="{{ url('register') }}">Create now</a></p>

                                <div class="form-group">
                                    <span class = "loading">
                                        <i class="fa fa-circle-o-notch fa-spin"></i>
                                    </span>
                                    <span class = "errors"></span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                

                
            </div>

            
        </div>
    </div>
</div>
@endsection

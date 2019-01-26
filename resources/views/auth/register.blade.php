@extends('layouts.app')

@section('title','Register')

@section('content')

<div class="container-fluid">
    <div class="row page-header">
        <h2>{{ env('APP_NAME') }} — online academic exchange platform<br />
            <small>Through us you can order an Essay, Term Paper, Dissertation, or other works!</small>
        </h2>   
    </div>
</div>

<div class="container fullscreen">
    <div class="row padding-tb-50">
        <div class="col-md-6 col-md-offset-3">
            <h3>Sign up</h3>
            <div class="panel panel-default">
                <div class="row  padding-tb-50">
                    <div class="col-md-10 col-md-offset-1">
                        <form class="auth-submit" role="form" method="POST" action="{{ url('/register') }}">
                            <div class="shake-div">   
                                {{ csrf_field() }}
                                
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Name *</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="form-group{{ $errors->has('user_type') ? ' has-error' : '' }}">
                                    <label for="user_type">I want to *</label>
                                    
                                    
                                    <select name="user_type" id="user_type" class="form-control">
                                        <option value="CLIENT"{{ old('user_type') == "CLIENT" ? ' selected'  : '' }}>Hire Freelancers</option>
                                        <option value="WRITER"{{ old('user_type') == "WRITER" ? ' selected'  : '' }}>Work</option>
                                    </select>
                                    
                                    @if ($errors->has('user_type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('usertype') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">E-Mail Address *</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="username">Username *</label>
                                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="password">Password *</label>
                                            <input id="password" type="password" class="form-control" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <label for="password-confirm">Confirm Password *</label>

                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                            @if ($errors->has('password_confirmation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="terms"> I accept terms and conditions *
                                        </label>
                                        <p><a href="{{ route('getTerms') }}">Terms and conditions</a></p>
                                                
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                                </div>

                                <p>Already have an account? <a href="{{ url('login') }}">Login here</a></p>

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

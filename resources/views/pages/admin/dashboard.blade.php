@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
   
<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-warning text-center">
                            <i class="ti-server"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Auction</p>
                            {{ number_format(count(App\Assignment::where('status','AUCTION')->where('deadline','>=',Carbon\Carbon::now()->toDateTimeString())->get())) }}
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="ti-reload"></i> Updated now
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-success text-center">
                            <i class="ti-wallet"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Revenue</p>
                            ${{ number_format(App\Settings::where('name','account_balance')->first()->value) }}
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="ti-calendar"></i> Now
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-danger text-center">
                            <i class="ti-pulse"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Writers</p>
                            {{ number_format(count(App\User::where('user_type','WRITER')->get())) }}
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="ti-timer"></i> Registered
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="icon-big icon-info text-center">
                            <i class="ti-twitter-alt"></i>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Clients</p>
                            {{ number_format(count(App\User::where('user_type','CLIENT')->get())) }}
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="ti-reload"></i> Registered
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
@endsection
<!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SABAWANAAG GENERAL TRADING</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-notifications.min.css') }}" rel="stylesheet">

    @yield('css')

<style>
    body {
        padding-top: 70px;
    }
</style>
    <!-- Scripts -->
    <script>
        window.Laravel =<?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <style>
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">

                        <img width="40" height="30" class="img img-rounded"
                             src="{{asset("css/logo.jpg")}}">

                    </a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li class="dropdown dropdown-notifications">
                            <a href="#notifications-panel" data-toggle="dropdown">
                                <i data-count="{{$alert_quantities->count()}}" class="glyphicon glyphicon-bell notification-icon"></i>
                            </a>

                            <div class="dropdown-container">

                                <div class="dropdown-toolbar">

                                    <h3 class="dropdown-toolbar-title">Notifications ({{$alert_quantities->count()}})</h3>
                                </div><!-- /dropdown-toolbar -->

                                <ul class="dropdown-menu">
                                    @foreach($alert_quantities as $item)
                                        <li class="notification">
                                            <div class="media">
                                                <div class="media-left">
                                                    <div class="media-object">
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <strong class="notification-title"><a href="#">{{$item->name}}</a> Quantity is <a href="#">{{$item->qty}}</a></strong>
                                                    <p class="notification-desc">Place an order for this Item as soon as possible.</p>

                                                    <div class="notification-meta">
                                                        <small class="timestamp">Category: {{$item->category->name}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>

                                <div class="dropdown-footer text-center">
                                    <a href="#">View All</a>
                                </div><!-- /dropdown-footer -->

                            </div><!-- /dropdown-container -->
                        </li><!-- /dropdown -->
                        <li {{Request::is('/')? "class=active":''}}><a href="{{url('/')}}">Home</a></li>
                        @if(Auth::user()->role=='owner' or Auth::user()->role=='sales')
                            <li {{Request::is('sale/create')? "class=active":''}}><a href="{{url('/sale/create')}}">Add Sale</a></li>
                            <li {{Request::is('purchase/create')? "class=active":''}}><a href="{{url('/purchase/create')}}">Add Purchase</a></li>
                        @endif
                        <li {{Request::is('sale')? "class=active":''}}><a href="{{url('/sale/')}}">All Sales</a></li>
                        <li {{Request::is('purchase')? "class=active":''}}><a href="{{url('/purchase/')}}">All Purchases</a></li>
                        <li {{Request::is('people')? "class=active":''}}><a href="{{url('/people')}}">Lists</a></li>
                        <li class="{{Request::is('item/summary') || Request::is('item/searchMovement')? 'active ':''}}dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Item Reports <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li {{Request::is('item/summary')? "class=active":''}}><a href="{{url('/item/summary')}}">Inventory</a></li>
                                <li {{Request::is('item/searchMovement')? "class=active":''}}><a href="{{url('/item/searchMovement')}}">Item Movements</a></li>
                            </ul>
                        </li>
                        @if(Auth::user()->role=='owner')
                            <li {{Request::is('/register')? "class=active":''}}><a href="{{url('/register')}}">Add User</a></li>
                            <li {{Request::is('/users/all')? "class=active":''}}><a href="{{url('/users/all')}}">All Users</a></li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>

                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/password/reset') }}" >
                                            Change Password
                                        </a>
                                    </li>
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
        </nav>



        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/angular.min.js')}}"></script>
    <link rel='stylesheet' href='{{asset('css/loading-bar.min.css')}}' type='text/css' media='all' />
    <script type='text/javascript' src='{{asset('js/loading-bar.min.js')}}'></script>

@yield('scripts')
<script>


</script>
</body>
</html>

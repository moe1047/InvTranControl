@extends('layouts.app')

@section('content')
<div class="container" ng-app="myApp" ng-init="capitals=[{'state':'HRG'},{'state':'TOG'},{'state':'AW'},{'state':'SAX'}]">
    <div class="row">
        <div class="col-md-2 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">Total Sales</div>

                <div class="panel-body" >
                    <h4 class="text-center">{{number_format($sales)}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2 ">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">Total Purchases</div>

                <div class="panel-body" >
                    <h4 class="text-center">{{number_format($purchases)}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">Total Pending Sales</div>

                <div class="panel-body" >
                    <h4 class="text-center">{{number_format($pendingSales)}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">Total Items</div>

                <div class="panel-body" >
                    <h4 class="text-center">{{number_format($itemsCount)}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-md-offset-2">
            <div class="panel panel-primary ">
                <div class="panel-heading text-center">Total Drivers</div>

                <div class="panel-body" >
                    <h4 class="text-center">{{number_format($drivers)}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2 ">
            <div class="panel panel-primary ">
                <div class="panel-heading text-center">Total Customers</div>

                <div class="panel-body" >
                    <h4 class="text-center">{{number_format($customers)}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">Total Branches</div>

                <div class="panel-body" >
                    <h4 class="text-center">{{number_format($branches)}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">Total Users</div>

                <div class="panel-body" >
                    <h4 class="text-center">{{number_format($users)}}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Alerts</div>

                <div class="panel-body" >
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

    @endsection

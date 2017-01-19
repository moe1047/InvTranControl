@extends('layouts.app')

@section('content')
<div class="container" ng-app="myApp" ng-init="capitals=[{'state':'HRG'},{'state':'TOG'},{'state':'AW'},{'state':'SAX'}]">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body" >
                    @foreach($items as $item)
                        @if($item->qty <= $item->alert_qty)
                            <div class="alert alert-danger alert-dismissible" >
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Warning!</strong> {{$item->name}} 's Quantity = {{$item->qty}}.
                            </div>

                        @endif
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

    @endsection

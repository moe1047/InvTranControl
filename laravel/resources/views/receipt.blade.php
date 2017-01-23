@extends('layouts.receipt')

@section('content')
    <div class="container" ng-app="myApp" ng-init="capitals=[{'state':'HRG'},{'state':'TOG'},{'state':'AW'},{'state':'SAX'}]">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="margin-bottom:3px">
                    <div class="panel-body" style="padding:2px">
                        <div >
                            <div style="margin-top:15px;margin-left:10px;float:left">
                                <img src="{{asset('css/logo.jpg')}}" class="img img-rounded" width="120" height="100">
                            </div>
                            <div style="margin-top:0px;margin-left:13%;float:left">
                                <h1 class="text-center" >Sabawanaag General Trading</h1>
                                <h5 class="text-center" style="text-decoration: underline;">Loading Stock</h5>
                                <p class="text-center"><b>Berbera:</b> 740794 <b>Hargeisa:</b> 524855 <b>Email:</b> tradingsaba@gmail.com</p>
                            </div>
                            <div style="margin-top:15px;margin-left:10px;float:right">
                                <img src="{{asset('css/logo.jpg')}}" class="img img-rounded" width="120" height="100">
                            </div>
                        </div>


                    </div>
                </div>
                <div class="panel panel-default" >
                    <div class="panel-body">
                        <table class="table table-bordered" style="margin:2px">
                            <tbody>
                            <tr>
                                <td><b>Sale ID</b></td><td>{{$sale->id}}</td><td><b>Date </b></td><td>{{$sale->sale_date}}</td>
                            </tr>

                            <tr>
                                <td><b>Customer </b></td><td>{{$sale->customer->name}}</td><td><b>Driver</b></td><td>{{$sale->driver->name}}</td>
                            </tr>

                            <tr>
                                <td><b>Order By</b></td><td>{{$sale->orderedBy->name}}</td><td><b>Plate No.</b></td><td>{{$sale->plate_no}}</td>

                            </tr>

                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <caption>Item List</caption>
                            <thead>
                            <tr>
                                <th>ID</th><th>Description</th><th>Qty</th><th>Shipped</th><th>Remaining</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sale->saleItems as $item)
                                <tr ng-repeat="sale in sales">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->item->name}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>{{$item->on_board}}</td>
                                    <td>{{$item->in_stock}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <h6><b>Submitted By:</b> {{$sale->user->name}}</h6>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h5>Driver:_______________________ &nbsp&nbsp&nbsp&nbsp&nbsp     Branch:_______________________</h5><h5 class="text-center"></h5>
                            </div>
                        </div>
                    </div>



                </div>
                ---------------------------------------------------------------------------------------------------------------<br><br>
                <div class="panel panel-default" style="margin-bottom:3px">
                    <div class="panel-body" style="padding:2px">
                        <div >
                            <div style="margin-top:15px;margin-left:10px;float:left">
                                <img src="{{asset('css/logo.jpg')}}" class="img img-rounded" width="120" height="100">
                            </div>
                            <div style="margin-top:0px;margin-left:13%;float:left">
                                <h1 class="text-center" >Sabawanaag General Trading</h1>
                                <h5 class="text-center" style="text-decoration: underline;">Loading Stock</h5>
                                <p class="text-center"><b>Berbera:</b> 740794 <b>Hargeisa:</b> 524855 <b>Email:</b> tradingsaba@gmail.com</p>
                            </div>
                            <div style="margin-top:15px;margin-left:10px;float:right">
                                <img src="{{asset('css/logo.jpg')}}" class="img img-rounded" width="120" height="100">
                            </div>
                        </div>


                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-bordered" style="margin:2px">
                            <tbody>
                            <tr>
                                <td><b>Sale ID</b></td><td>{{$sale->id}}</td><td><b>Date </b></td><td>{{$sale->sale_date}}</td>
                            </tr>

                            <tr>
                                <td><b>Customer </b></td><td>{{$sale->customer->name}}</td><td><b>Driver</b></td><td>{{$sale->driver->name}}</td>
                            </tr>

                            <tr>
                                <td><b>Order By</b></td><td>{{$sale->orderedBy->name}}</td><td><b>Plate No.</b></td><td>{{$sale->plate_no}}</td>

                            </tr>

                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <caption>Item List</caption>
                            <thead>
                            <tr>
                                <th>ID</th><th>Description</th><th>Qty</th><th>Shipped</th><th>Remaining</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sale->saleItems as $item)
                                <tr ng-repeat="sale in sales">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->item->name}}</td>
                                    <td>{{$item->qty}}
                                    <td>{{$item->on_board}}</td>
                                    <td>{{$item->in_stock}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <h6><b>Submitted By:</b> {{$sale->user->name}}</h6>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="panel-body">
                                    <h5>Driver:_______________________ &nbsp&nbsp&nbsp&nbsp&nbsp     Branch:_______________________</h5><h5 class="text-center"></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection

@extends('layouts.receipt')

@section('content')
    <div class="container" ng-app="myApp" ng-init="capitals=[{'state':'HRG'},{'state':'TOG'},{'state':'AW'},{'state':'SAX'}]">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h1 class="text-center">SSG LTD</h1>
                        <h5 class="text-center">Pick UP Receipt</h5>
                    </div>
                </div>
                <div class="panel panel-default" >
                    <div class="panel-body">
                        <table class="table table-bordered" style="margin:2px">
                            <tbody>
                            <tr >
                                <td><b>Tran ID</b></td><td>{{$saleItemTran->id}}</td><td><b>Date </b></td><td>{{$saleItemTran->created_at}}</td>
                            </tr>

                            <tr >
                                <td><b>Customer </b></td><td>{{$saleItemTran->customer->name}}</td><td><b>Driver</b></td><td>{{$saleItemTran->driver->name}}</td>
                            </tr>

                            <tr >
                                <td><b>Order By</b></td><td>{{$saleItemTran->orderedBy->name}}</td><td><b>Plate No.</b></td><td>{{$saleItemTran->plate_no}}</td>

                            </tr>

                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <caption>Item List</caption>
                            <thead>
                            <tr>
                                <th>ID</th><th>Description</th><th>Qty</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sale->saleItems as $item)
                                <tr ng-repeat="sale in sales">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->item->name}}</td>
                                    <td>{{$item->qty}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h5>Driver:_______________________ &nbsp&nbsp&nbsp&nbsp&nbsp     Branch:_______________________</h5><h5 class="text-center"></h5>
                            </div>
                        </div>
                    </div>



                </div>
                ---------------------------------------------------------------------------------------------------------------<br><br>
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
                                <th>ID</th><th>Description</th><th>Qty</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sale->saleItems as $item)
                                <tr ng-repeat="sale in sales">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->item->name}}</td>
                                    <td>{{$item->qty}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
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

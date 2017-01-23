@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default" ng-controller="saleList">
                    <div class="panel-heading">Sale Detail</div>
                    <div class="panel-body" style="padding:2px">
                        <div >
                            <div style="margin-top:15px;margin-left:10px;float:left">
                                <img src="{{asset('css/logo.jpg')}}" class="img img-rounded" width="120" height="100">
                            </div>
                            <div style="margin-top:0px;margin-left:16%;float:left">
                                <h1 class="text-center" >Sabawanaag General Trading</h1>
                                <h5 class="text-center" style="text-decoration: underline;">Summary Report</h5>
                                <p class="text-center"><b>Berbera:</b> 740794 <b>Hargeisa:</b> 524855 <b>Email:</b> tradingsaba@gmail.com</p>
                            </div>
                            <div style="margin-top:15px;margin-left:10px;float:right">
                                <img src="{{asset('css/logo.jpg')}}" class="img img-rounded" width="120" height="100">
                            </div>
                        </div>


                        <div id="sale" class="col-xs-12" ng-if="View == 'Sales'">
                            <div class="col-md-12">
                                <table class="table table-bordered">

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
                                    <tr>
                                        <td><b>Note</b></td><td>{{$sale->note}}</td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <caption>Item List</caption>
                                    <thead>
                                    <tr>
                                        <th>ID</th><th>Description</th><th>Qty</th><th>On Board</th><th>Remaining</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sale->saleItems as $item)
                                        <tr ng-repeat="sale in sales">
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->item->name}}</td>
                                            <td>{{number_format($item->qty)}}</td>
                                            <td>{{number_format($item->on_board)}}</td>
                                            <td>{{number_format($item->in_stock)}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <caption>Item Transaction History</caption>
                                    <thead>

                                    </thead>
                                    <tbody>
                                    @foreach($sale->saleItems as $item)
                                        <tr>
                                            <td>{{$item->item->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Tran ID</th><th>Shipped</th><th>Remaining</th><th>Driver</th><th>Plate No</th><th>Note</th><th>Date</th>
                                        </tr>

                                            @foreach($item->SaleItemTransactions as $transaction)
                                                <tr>
                                                <td>{{$transaction->id}}</td>
                                                <td>{{$transaction->on_board}}</td>
                                                <td>{{$transaction->in_stock}}</td>
                                                    <td>{{$transaction->driver->name}}</td>
                                                    <td>{{$transaction->plate_no}}</td>
                                                    <td>{{$transaction->note}}</td>
                                                <td>{{$transaction->created_at}}</td>
                                                </tr>
                                            @endforeach


                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


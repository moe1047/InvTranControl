@extends('layouts.receipt')

@section('content')
    <div class="container" ng-app="myApp" ng-init="capitals=[{'state':'HRG'},{'state':'TOG'},{'state':'AW'},{'state':'SAX'}]">
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default" style="margin-bottom:3px">
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


                    </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>SaleID</th>
                                <th>Customer</th>
                                <th>Driver</th>
                                <th>Order By</th>
                                <th>Plate No</th>
                                <th>status</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Shipped</th>
                                <th>Remaining</th>
                            </tr>
                            </thead>
                            <tbody
                            <?php $totalItems=0;$totalOnBoard=0;$totalInStock=0?>
                            @foreach($sales as $sale)
                                <?php
                                    $totalItems+=$sale->FilterItem($item_id)->sum('qty');
                                    $totalOnBoard+=$sale->FilterItem($item_id)->sum('on_board');
                                    $totalInStock+=$sale->FilterItem($item_id)->sum('in_stock')
                                    ?>
                                <tr>
                                    <td rowspan="{{$item_id==''?$sale->ItemsCount()+1:2}}">{{$sale->id}}</td>
                                    <td rowspan="{{$item_id==''?$sale->ItemsCount()+1:2}}">{{$sale->customer->name}}</td>
                                    <td rowspan="{{$item_id==''?$sale->ItemsCount()+1:2}}">{{$sale->driver->name}}</td>
                                    <td rowspan="{{$item_id==''?$sale->ItemsCount()+1:2}}">{{$sale->orderedBy->name}}</td>
                                    <td rowspan="{{$item_id==''?$sale->ItemsCount()+1:2}}">{{$sale->plate_no}}</td>
                                    <td rowspan="{{$item_id==''?$sale->ItemsCount()+1:2}}">{{$sale->status}}</td>
                                    <td rowspan="{{$item_id==''?$sale->ItemsCount()+1:2}}">{{$sale->created_at->toDateString()}}</td>
                                    <td rowspan="{{$item_id==''?$sale->ItemsCount()+1:2}}">{{$sale->user->name}}</td>
                                </tr>

                                @foreach($sale->FilterItem($item_id) as $sale_item)
                                    <tr>
                                        <td>
                                            {{$sale_item->Item->name}}
                                        </td>
                                        <td>
                                            {{number_format($sale_item->qty)}}
                                        </td>
                                        <td>
                                            {{number_format($sale_item->on_board)}}
                                        </td>
                                        <td>
                                            {{number_format($sale_item->in_stock)}}
                                        </td>
                                    </tr>
                                @endforeach

                            @endforeach
                            <tr>
                                <td colspan="8"></td>

                                <td><b>TOTAL:</b></td>
                                <td><b>{{$totalItems}}</b></td>
                                <td><b>{{$totalOnBoard}}</b></td>
                                <td><b>{{$totalInStock}}</b></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
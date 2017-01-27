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
                            <div style="margin-top:0px;margin-left:13%;float:left">
                                <h1 class="text-center" >Sabawanaag General Trading</h1>
                                <h5 class="text-center" style="text-decoration: underline;">Item Movements</h5>
                                <h5 class="text-center" style="text-decoration: underline;"><b>Item:</b> {{$item_name}} (<b>From:</b> {{$from}}- <b>To:</b> {{$to}})</h5>
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
                            <th>Date</th>
                            <th>Tran Type</th>
                            <th>ID</th>
                            <th>Customer ID</th>
                            <th>Ordered By</th>
                            <th>Qty</th>
                            <th>Balance</th>
                        </tr>
                        </thead>
                            @foreach($itemMovements as $itemMovement)
                                    <tbody>
                                        <tr class="{{$itemMovement->tran_type=='delete_sale' || $itemMovement->tran_type=='delete_purchase'?'danger':''}}">
                                            <td>{{$itemMovement->created_at}}</td>
                                            <td>{{$itemMovement->tran_type}}</td>

                                            @if($itemMovement->tran_type=='add_sale' or $itemMovement->tran_type=='add_purchase')
                                                <td>{{$itemMovement->tran_type_id}}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if($itemMovement->tran_type=='add_sale' )
                                                @if($itemMovement->saleExists($itemMovement->tran_type_id))
                                                    <td>{{$itemMovement->sale->customer->name}}</td>
                                                    <td>{{$itemMovement->sale->orderedBy->name}}</td>
                                                    @else
                                                    <td>Deleted</td>
                                                    <td>Deleted</td>
                                                @endif

                                            @else
                                            <td>-</td>
                                            <td>-</td>

                                            @endif

                                            <td>{{$itemMovement->qty}}</td>
                                            <td>{{$itemMovement->in_stock}}</td>
                                        </tr>
                                    </tbody>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
@extends('layouts.receipt')

@section('content')
    <div class="container">
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
                                <h5 class="text-center" style="text-decoration: underline;">Purchase Report</h5>
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
                        <h5 class="text-center"><b>From:</b>{{$from}} - <b>To:</b>{{$to}}</h5>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>PurchaseID</th>
                                <th>Purchased Date</th>
                                <th>Ship Name</th>
                                <th>Origin Country</th>
                                <th>Item</th>
                                <th>Qty</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td rowspan="{{$item_id==''?$purchase->ItemsCount()+1:2}}">{{$purchase->id}}</td>
                                    <td rowspan="{{$item_id==''?$purchase->ItemsCount()+1:2}}">{{$purchase->purchased_date}}</td>
                                    <td rowspan="{{$item_id==''?$purchase->ItemsCount()+1:2}}">{{$purchase->ship_name}}</td>
                                    <td rowspan="{{$item_id==''?$purchase->ItemsCount()+1:2}}">{{$purchase->origin_country}}</td>
                                </tr>

                                    @foreach($purchase->FilterItem($item_id) as $purchase_item)
                                        <tr>
                                            <td>
                                                {{$purchase_item->Item->name}}
                                            </td>
                                            <td>
                                                {{number_format($purchase_item->qty)}}
                                            </td>
                                        </tr>
                                    @endforeach


                            @endforeach
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
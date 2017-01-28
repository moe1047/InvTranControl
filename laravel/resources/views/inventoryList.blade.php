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
                                <h5 class="text-center" style="text-decoration: underline;">Inventory List</h5>
                                <h5 class="text-center" style="text-decoration: underline;"><b>Date:</b> {{$today}}</h5>
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
                        @foreach($categories as $category)
                            <table class="table table-striped table-bordered ">
                                <caption>{{$category->name}}</caption>
                                <thead>
                                <tr>
                                    <th>ItemID</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Remaining</th>
                                    <th>Total In stock</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($category->Items as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{number_format($item->qty)}}</td>
                                        <td>{{number_format($item->getPending())}}</td>
                                        <td>{{number_format($item->getPending()+$item->qty)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
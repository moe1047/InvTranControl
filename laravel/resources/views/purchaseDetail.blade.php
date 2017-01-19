@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default" ng-controller="saleList">
                    <div class="panel-heading">Sale Detail</div>
                    <div class="panel-body" >


                        <div id="sale" class="col-xs-12" ng-if="View == 'Sales'">

                            <table class="table table-bordered">

                                <tbody>
                                <tr>
                                    <td><b>Purchase ID</b></td><td>{{$purchase->id}}</td><td><b>Date </b></td><td>{{$purchase->purchased_date}}</td>
                                </tr>

                                <tr>
                                    <td><b>Ship Name </b></td><td>{{$purchase->ship_name}}</td><td><b>Origin Country</b></td><td>{{$purchase->origin_country}}</td>
                                </tr>


                                </tbody>
                            </table>
                            <div >
                                <table class="table table-bordered">
                                    <caption>Item List</caption>
                                    <thead>
                                    <tr>
                                        <th>ID</th><th>Description</th><th>Qty</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($purchase->purchaseItems as $item)
                                        <tr ng-repeat="sale in sales">
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->item->name}}</td>
                                            <td>{{number_format($item->qty)}}</td>
                                        </tr>
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


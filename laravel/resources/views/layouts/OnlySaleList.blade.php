@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default" ng-controller="saleList">
                    <div class="panel-heading">Sale List</div>
                    <div class="panel-body" >

                        <div id="sale" class="col-xs-12" ng-if="View == 'Sales'">
                            @include('layouts.saleSearchForm')
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>SaleID</th><th>Date</th><th>Customer</th><th>Driver</th><th>Branch</th><th>Plate No</th><th>Status</th>
                                    <th>Print</th>
                                    @if(Auth::user()->role=='owner' or Auth::user()->role=='sales')
                                        <th>Actions</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sales as $sale)
                                    <tr>
                                        <td>{{$sale->id}}</td>
                                        <td>{{$sale->sale_date->toDateString()}}</td>
                                        <td>{{$sale->customer->name}}</td>
                                        <td>{{$sale->driver->name}}</td>
                                        <td>{{$sale->orderedBy->name}}</td>
                                        <td>{{$sale->plate_no}}</td>
                                        <td><h4 style="margin-top: 3px;"><span class="{{$sale->status=='pending'?'label label-warning' :'label label-success'}}" >{{$sale->status}}</span></h4></td>
                                        <td><a href="/sale/{{$sale->id}}/print" class="btn btn-default btn-sm" target="_blank">Print</a></td>
                                        @if(Auth::user()->role=='owner' or Auth::user()->role=='sales')
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    Action
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

                                                    @if($sale->status=='pending')
                                                        <li><a href="{{url("/sale/$sale->id/complete")}}">Complete</a></li>
                                                        <li><a href="{{url("/sale/$sale->id/cancelRemaining")}}">Cancel Remaining</a></li>
                                                    @endif

                                                    <li><a href="{{url("/sale/$sale->id/detail")}}"  target="_blank">Detail</a></li>
                                                    <li role="separator" class="divider"></li>
                                                    <li><a href="" ng-click="delSaleConfirmation({{$sale->id}})" onclick="return false">Delete</a></li>

                                                </ul>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="text-ceneter">
                                {{ $sales->appends(Request::only('from'),Request::only('to'),Request::only('driver_id')
                                ,Request::only('customer_id'),Request::only('branch_id'),Request::only('item_id'),Request::only('plate_no'),Request::only('status'))->links() }}

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/sweetalert.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/sweetalert.css')}}">
    <script src="{{asset('js/ui-bootstrap-tpls-2.4.0.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2-bootstrap.css')}}">
    <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/select2.js')}}"></script>

    <script>
        myApp=angular.module('myApp',['angular-loading-bar','ui.bootstrap','ui.select2']).config(['$httpProvider', function($httpProvider) {
            $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
        }]);
        myApp.config(function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });

        myApp.controller('saleList',function($scope,$http){
            //date picker
            $scope.today = function() {
                $scope.dt = new Date();
            };
            $scope.today();

            $scope.clear = function() {
                $scope.dt = null;
            };

            $scope.options = {
                customClass: getDayClass,
                minDate: new Date(),
                showWeeks: true
            };

            // Disable weekend selection
            function disabled(data) {
                var date = data.date,
                        mode = data.mode;
                return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
            }

            $scope.toggleMin = function() {
                $scope.options.minDate = $scope.options.minDate ? null : new Date();
            };

            $scope.toggleMin();

            $scope.setDate = function(year, month, day) {
                $scope.dt = new Date(year, month, day);
            };

            var tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            var afterTomorrow = new Date(tomorrow);
            afterTomorrow.setDate(tomorrow.getDate() + 1);
            $scope.events = [
                {
                    date: tomorrow,
                    status: 'full'
                },
                {
                    date: afterTomorrow,
                    status: 'partially'
                }
            ];

            function getDayClass(data) {
                var date = data.date,
                        mode = data.mode;
                if (mode === 'day') {
                    var dayToCheck = new Date(date).setHours(0,0,0,0);

                    for (var i = 0; i < $scope.events.length; i++) {
                        var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                        if (dayToCheck === currentDay) {
                            return $scope.events[i].status;
                        }
                    }
                }

                return '';
            }
            $scope.today = function() {
                $scope.dt = new Date();
            };
            $scope.today();

            $scope.clear = function() {
                $scope.dt = null;
            };

            $scope.inlineOptions = {
                customClass: getDayClass,
                minDate: new Date(),
                showWeeks: true
            };

            $scope.dateOptions = {
                dateDisabled: disabled,
                formatYear: 'yy',
                maxDate: new Date(2020, 5, 22),
                minDate: new Date(),
                startingDay: 1
            };

            // Disable weekend selection
            function disabled(data) {
                var date = data.date,
                        mode = data.mode;
                return mode === 'day' && (date.getDay() === 7 || date.getDay() === 8);
            }

            $scope.toggleMin = function() {
                $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
                $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
            };

            $scope.toggleMin();

            $scope.open1 = function() {
                console.log($scope.submittedData.from)
                $scope.popup1.opened = true;
            };

            $scope.open2 = function() {
                $scope.popup2.opened = true;
            };

            $scope.setDate = function(year, month, day) {
                $scope.dt = new Date(year, month, day);
            };

            $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
            $scope.format = $scope.formats[0];
            $scope.altInputFormats = ['M!/d!/yyyy'];

            $scope.popup1 = {
                opened: false
            };

            $scope.popup2 = {
                opened: false
            };

            var tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            var afterTomorrow = new Date();
            afterTomorrow.setDate(tomorrow.getDate() + 1);
            $scope.events = [
                {
                    date: tomorrow,
                    status: 'full'
                },
                {
                    date: afterTomorrow,
                    status: 'partially'
                }
            ];

            function getDayClass(data) {
                var date = data.date,
                        mode = data.mode;
                if (mode === 'day') {
                    var dayToCheck = new Date(date).setHours(0,0,0,0);

                    for (var i = 0; i < $scope.events.length; i++) {
                        var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                        if (dayToCheck === currentDay) {
                            return $scope.events[i].status;
                        }
                    }
                }

                return '';
            }
            $scope.delSaleConfirmation=function($sale_id){
                swal({
                            title: "Are you sure?",
                            text: "Your will not be able to recover this imaginary file!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "No, cancel plx!",
                            closeOnConfirm: false,
                            closeOnCancel: false },
                        function(isConfirm){
                            if (isConfirm) {
                                $http({
                                    method : "get",
                                    url : "/sale/"+$sale_id+"/delete"
                                }).then(function Succes(response) {
                                    $scope.sales=[];
                                    $http.get('/sale').then(function(result){
                                        console.log(result.data);
                                        $scope.sales=result.data;
                                    });
                                    swal("Deleted!", "Sale has been deleted.", "success");
                                    location.reload();
                                }, function Error(response) {
                                    swal("Error", "Something went wrong", "error");
                                });
                            } else {
                                swal("Cancelled", "Your Sale is safe :)", "error");
                            }
                        });
            };
            $scope.delItemConfirmation=function($item_id){
                swal({
                            title: "Are you sure?",
                            text: "Your will not be able to recover this imaginary file!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "No, cancel plx!",
                            closeOnConfirm: false,
                            closeOnCancel: false },
                        function(isConfirm){
                            if (isConfirm) {
                                $http({
                                    method : "post",
                                    url : "/item/"+$item_id+"/delete"
                                }).then(function Succes(response) {
                                    //refresh items list
                                    $scope.items=[];
                                    $http.get('/item/all').then(function(result){
                                        $scope.items=result.data;
                                    });
                                    console.log(response.data);
                                    swal("Deleted!", response.data, "success");
                                }, function Error(response) {
                                    console.log(response.data);
                                    swal("Error", response.data, "error");
                                });
                            } else {
                                swal("Cancelled", "Your Item is safe :)", "error");
                            }
                        });
            };

            $scope.selectedView='Sales';
            $scope.View='Sales';


            //SEARCH FORM
            //get the selected items
            $scope.submittedData={
                sale_id:'',
                from:'',
                to:'',
                customer_id:'',
                item_id:'',
                driver_id:'',
                branch_id:'',
                plate_no:'',
                status:'completed'
            };


        });
    </script>

@endsection

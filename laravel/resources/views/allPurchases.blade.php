@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-12 ">

                <div class="panel panel-default" ng-controller="purchaseList">
                    <div class="panel-heading">Purchase List</div>
                    <div class="panel-body" >

                        <div id="sale" class="col-xs-12" ng-if="View == 'Sales'">
                            @include('layouts.purchaseSearchForm')

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>PurchaseID</th><th>Date</th><th>Ship Name</th><th>Origin Country</th><th>Items</th>
                                    @if(Auth::user()->role=='owner' or Auth::user()->role=='sales')
                                        <th>Actions</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($purchases as $purchase)
                                    <tr>
                                        <td>{{$purchase->id}}</td>
                                        <td>{{$purchase->purchased_date->format('d/m/Y')}}</td>
                                        <td>{{$purchase->ship_name}}</td>
                                        <td>{{$purchase->origin_country}}</td>

                                        <td>
                                            @foreach($purchase->purchaseItems as $purchaseItem)
                                                {{$purchaseItem->item->name}}- {{$purchaseItem->qty}}<br>
                                            @endforeach
                                        </td>
                                        @if(Auth::user()->role=='owner' or Auth::user()->role=='sales')
                                            <td><a class="btn btn-danger btn-sm" ng-click="delPurchaseConfirmation({{$purchase->id}})">Delete</a>
                                            </td>
                                        @endif

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="text-ceneter">
                                {{ $purchases->appends(Request::only('origin_country'),Request::only('from'),Request::only('to')
                                ,Request::only('ship_name'),Request::only('origin_country'),Request::only('item_id'))->links() }}

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

        myApp.controller('purchaseList',function($scope,$http){
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

            $scope.delPurchaseConfirmation=function($purchase_id){
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
                                console.log($purchase_id);
                                $http({
                                    method : "post",
                                    url : "/purchase/"+$purchase_id+"/delete"
                                }).then(function Succes(response) {

                                    $scope.purchases=[];
                                    $http.get('/purchase').then(function(result){
                                        //console.log(result.data);
                                        $scope.purchases=result.data;
                                    });

                                    console.log("ID="+$purchase_id);
                                    console.log(response.data);
                                    swal("Deleted!", "Purchase has been deleted.", "success");
                                    location.reload();
                                }, function Error(response) {
                                    console.log(response.data);
                                    swal("Error", "Something went wrong", "error");
                                });
                            } else {
                                swal("Cancelled", "Your Purchase is safe :)", "error");
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

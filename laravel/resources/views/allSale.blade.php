@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default" ng-controller="saleList">
                    <div class="panel-heading">[[View]]</div>
                    <div class="panel-body" >
                        <div class="col-md-2"  style="margin-bottom:12px;">
                            <select class="form-control" ng-change="checkView()" ng-model="selectedView">
                                <option value="Purchases">Purchases</option><option value="Items">Items</option>
                            </select>
                        </div>


                        <div id="purchase" ng-if="View == 'Purchases'">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>PurchaseID</th><th>Date</th><th>ship_name</th><th>origin_country</th><th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="purchase in purchases">
                                    <td>[[purchase.id]]</td>
                                    <td>[[purchase.purchased_date]]</td>
                                    <td>[[purchase.ship_name]]</td>
                                    <td>[[purchase.origin_country]]</td>
                                    <td><a href="purchase/[[purchase.id]]/detail" class="btn btn-default btn-sm" target="_blank">Detail</a></td>
                                    <td><a href="" ng-click="delPurchaseConfirmation(purchase.id)" class="btn btn-danger btn-sm" >Delete</a></td>

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
                                    console.log(response.data);
                                    swal("Deleted!", "Sale has been deleted.", "success");
                                }, function Error(response) {
                                    console.log(response.data);
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
            $scope.search=function(){
                //console.log("hey");
                $http({
                    method : "post",
                    url : "/sale/search",
                    data:$scope.submittedData
                }).then(function Succes(response) {
                    $scope.sales=[];
                    $scope.sales=response.data;
                    console.log(response.data);
                    //console.log($scope.submittedData);
                }, function Error(response) {
                    console.log(response.data);
                });

            };

            $http.get('/items').then(function(result){
                $scope.items=result.data;
            });
            $http.get('/customers').then(function(result){
                $scope.customers=result.data;
            });
            $http.get('/drivers').then(function(result){
                $scope.drivers=result.data;
            });
            $http.get('/branches').then(function(result){
                $scope.branches=result.data;
            });


            $http.get('/sale').then(function(result){
                console.log(result.data);
                $scope.sales=result.data;
            });
            $http.get('/purchase').then(function(result){
                console.log(result.data);
                $scope.purchases=result.data;
            });
            $http.get('/item/all').then(function(result){
                console.log(result.data);
                $scope.items=result.data;
            });
            $scope.checkView=function(){
                console.log($scope.selectedView);
                $scope.View=$scope.selectedView;

            }
        });
    </script>

@endsection

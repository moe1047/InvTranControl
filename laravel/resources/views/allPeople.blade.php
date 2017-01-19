@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default" ng-controller="saleList" ng-cloak>
                    <div class="panel-heading">[[View]]</div>
                    <div class="panel-body" >
                        <div class="col-md-2">
                            <select class="form-control" ng-change="checkView()" ng-model="selectedView">
                                <option value="Drivers">Drivers</option><option value="Customers">Customers</option><option value="Branches">Branches</option><option value="Items">Items</option>
                            </select>
                        </div>

                        <div id="drivers" class="col-xs-12" ng-if="View == 'Drivers'">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th><th>No</th><th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="driver in drivers">
                                    <td>[[driver.name]]</td>
                                    <td>[[driver.no]]</td>
                                    <td><a href="" class="btn btn-danger btn-sm" ng-click="confirmation(driver.id)">Delete</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="customers" class="col-xs-12" ng-if="View == 'Customers'">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th><th>No</th><th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="customer in customers">
                                    <td>[[customer.name]]</td>
                                    <td>[[customer.no]]</td>
                                    <td><a href="" class="btn btn-danger btn-sm" ng-click="confirmation(customer.id)">Delete</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="branches" class="col-xs-12" ng-if="View == 'Branches'">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th><th>No</th><th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="branch in branches">
                                    <td>[[branch.name]]</td>
                                    <td>[[branch.no]]</td>
                                    <td><a href="" class="btn btn-danger btn-sm" ng-click="confirmation(branch.id)">Delete</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="items" class="col-xs-12" ng-if="View == 'Items'">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th><th>qty</th><th>Alert Quantity</th><th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="item in items">
                                    <td>[[item.name]]</td>
                                    <td>[[item.qty]]</td>
                                    <td>[[item.alert_qty]]</td>
                                    <td><a href="" class="btn btn-danger btn-sm" ng-click="delItemConfirmation(item.id)">Delete</a></td>
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
    <script>
        myApp=angular.module('myApp',['angular-loading-bar']);
        myApp.config(function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });

        myApp.controller('saleList',function($scope,$http){
            $scope.selectedView='Customers';
            $scope.View='Customers';
            $http.get('/people/customers').then(function(result){
                console.log(result.data);
                $scope.customers=result.data;
            });
            $http.get('/people/drivers').then(function(result){
                console.log(result.data);
                $scope.drivers=result.data;
            });
            $http.get('/people/branches').then(function(result){
                console.log(result.data);
                $scope.branches=result.data;
            });


            $scope.confirmation=function($people_id){
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
                                    url : "/people/"+$people_id+"/delete"
                                }).then(function Succes(response) {
                                    console.log(response.data);
                                    $scope.branches=[];$scope.drivers=[];$scope.customers=[];

                                    $http.get('/people/branches').then(function(result){
                                        $scope.branches=result.data;
                                    });
                                    $http.get('/people/drivers').then(function(result){
                                        $scope.drivers=result.data;
                                    });
                                    $http.get('/people/customers').then(function(result){
                                        $scope.customers=result.data;
                                    });

                                    swal("Deleted!", "One Person has been deleted.", "success");
                                }, function Error(response) {
                                    console.log(response.data);
                                    swal("Error",response.data.message, "error");
                                });
                            } else {
                                swal("Cancelled", "", "error");
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
            $http.get('/items').then(function(result){
                $scope.items=result.data;
            });

            $scope.checkView=function(){
                console.log($scope.selectedView);
                $scope.View=$scope.selectedView;

            }

        });
    </script>

@endsection

@extends('layouts.app')
@section('css')

@endsection
@section('content')

    <div class="container" ng-controller="sale" ng-cloak>
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add Sale</div>
                    <div class="panel-body" >
                        <div class="alert alert-success alert-dismissible" ng-show="success" ng-cloak>
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Sales has been added successfully.
                        </div>
                        <div class="alert alert-danger alert-dismissible" ng-show="error" ng-cloak>
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error!</strong> something went wrong Please re-check the Sale Form.
                        </div>
                        @include('layouts.saleForm');
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.driverModel');
        @include('layouts.customerModel');
        @include('layouts.branchModel');

    </div>
@endsection
@section('scripts')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2-bootstrap.css')}}">
    <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/select2.js')}}"></script>
    <script>
        var branch='';

        myApp=angular.module('myApp',['angular-loading-bar','ui.select2']);
        myApp.config(function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });

        myApp.controller('sale',function($scope,$http,$timeout,$window){
            $scope.branch='';
            $scope.branch_name='';$scope.branch_no='';
            $scope.customer_name='';$scope.customer_no='';
            $scope.driver_name='';$scope.driver_no='';
            $scope.item_name='';$scope.item_qty='';$scope.item_alert_qty='';
            $scope.calculateRemaining=function(key){
                $scope.selectedItems[key].in_stock=$scope.selectedItems[key].qty-$scope.selectedItems[key].on_board
            }
            $scope.submitCustomer=function(){
                //console.log("hey");
                $http({
                    method : "post",
                    url : "/people/customers/create",
                    data:{'name':$scope.customer_name,'no':$scope.customer_no,'branch_id':$scope.customer_branch_id}
                }).then(function Succes(response) {
                    $scope.customer_name='';$scope.customer_no='';$scope.customer_branch_id='';
                    location.reload();
                    console.log(response.data);
                    //console.log($scope.submittedData);
                }, function Error(response) {
                    console.log(response.data);
                });

            };
            $scope.submitDriver=function(){
                //console.log("hey");
                $http({
                    method : "post",
                    url : "/people/drivers/create",
                    data:{'name':$scope.driver_name,'no':$scope.driver_no}
                }).then(function Succes(response) {
                    $scope.driver_name='';$scope.driver_no='';
                    location.reload();
                    console.log(response.data);
                    //console.log($scope.submittedData);
                }, function Error(response) {
                    console.log(response.data);
                });

            };
            $scope.submitBranch=function(){
                //console.log("hey");
                $http({
                    method : "post",
                    url : "/people/branches/create",
                    data:{'name':$scope.branch_name,'no':$scope.branch_no}
                }).then(function Succes(response) {
                    $scope.branch_name='';$scope.branch_no='';
                    location.reload();
                    console.log(response.data);
                    //console.log($scope.submittedData);
                }, function Error(response) {
                    console.log(response.data);
                });

            };

            $scope.success=false;
            $scope.selectedItems=[];
            $scope.selectedItem=0;//from item dropdown
            $scope.selectedDriver=1;//from item dropdown
            $scope.selectedCustomer='';//from item dropdown
            $scope.selectedBranch=0;//from item dropdown
            $scope.selectedPlateNo='';//from item text
            $scope.selectedNote="";//from item textarea
            $scope.addItem=function(){
                var found =false;
                for(var i = 0; i < $scope.selectedItems.length; i++) {
                    if ($scope.selectedItems[i].id == $scope.selectedItem) {
                        found = true;
                        $scope.selectedItems[i].qty=parseInt($scope.selectedItems[i].qty+1);
                        $scope.selectedItems[i].on_board=$scope.selectedItems[i].qty;
                        //$scope.selectedItems[i].in_stock=parseInt($scope.selectedItems[i].qty+1);
                        break;
                    }
                }
                if(!found){
                    //search for selected item Object in items by Id
                    for(var i = 0; i < $scope.items.length; i++) {
                        if ($scope.items[i].id == $scope.selectedItem) {
                            //after found ,create new object and assign into it
                            var obj = {
                                id: $scope.selectedItem,
                                name:$scope.items[i].name,
                                qty:0,
                                stock:$scope.items[i].qty,
                                on_board:0,
                                in_stock:0
                            };
                            $scope.selectedItems.push(obj);
                            break;
                        }
                    }


                }

                //var itemss=$scope.selectedItems;
                //console.log($scope.selectedItems);
                console.log($scope.submittedData);
                //console.log($scope.items[0]);
            };
            $scope.removeItem=function(index){
                $scope.selectedItems.splice(index, 1);
                //var itemss=$scope.selectedItems;
                console.log($scope.selectedItems);
            };
            $http.get('/items').then(function(result){
                $scope.items=result.data;
            });

            //get the selected items
            $scope.submittedData={
                customer_id:'',
                items:$scope.selectedItems,
                driver_id:'',
                ordered_by:0,
                plate_no:'',
                note:''
            };

            //Submit sale
            $scope.submit=function(){
                //update items in submittedData
                $scope.submittedData.items=$scope.selectedItems;
                $http({
                    method : "post",
                    url : "/sale",
                    data:$scope.submittedData
                }).then(function Succes(response) {
                    $scope.success=true;$scope.error=false;$scope.selectedItems=[];$scope.selectedItem=0;
                    //generate the items again to update quantity
                    $http.get('/items').then(function(result){
                        $scope.items=result.data;
                    });
                    //hide success alert after 60 seconds
                    window.location.href = "/sale/"+response.data+"/print";
                    console.log(response.data);
                    //console.log($scope.submittedData);
                }, function Error(response) {
                    $scope.error=true;$scope.success=false;
                    console.log(response.data);
                });
            }
            $scope.update_on_board=function(key){
                $scope.selectedItems[key].on_board=$scope.selectedItems[key].qty;
                $scope.selectedItems[key].in_stock=0;
                console.log($scope.selectedItems[key].on_board);
            }
            $scope.get_customer_branch=function(){
                var customer =document.getElementById('customer');
                branch = customer.options[customer.selectedIndex].getAttribute('data-branch');
                console.log(typeof($scope.submittedData.ordered_by=$window.branch.toString()));

                //alert(branch);
            }


        });

    </script>

    @endsection

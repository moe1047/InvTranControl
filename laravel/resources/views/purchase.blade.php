@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container" ng-controller="purchase" ng-cloak>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Add purchase</div>
                    <div class="panel-body"  >
                        <div class="alert alert-success alert-dismissible" ng-show="success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Purchases has been added successfully.
                        </div>
                        <div class="alert alert-danger alert-dismissible" ng-show="error">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Error!</strong> something went wrong.
                        </div>
                        @include('layouts.purchaseForm');
                    </div>
                    @include('layouts.itemModel');
                    @include('layouts.categoryModel');
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2-bootstrap.css')}}">
    <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/select2.js')}}"></script>
    <script>
        myApp=angular.module('myApp',['angular-loading-bar','ui.select2']);
        myApp.config(function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });

        myApp.controller('purchase',function($scope,$http){
            $http.get('/items').then(function(result){
                $scope.items=result.data;
            });
            $scope.selectedItems=[];
            $scope.selectedItem=0;//from item dropdown submitCategory()
            $scope.category_name='';


            $scope.addItem=function(){
                var found =false;
                for(var i = 0; i < $scope.selectedItems.length; i++) {
                    if ($scope.selectedItems[i].id == $scope.selectedItem) {
                        found = true;
                        $scope.selectedItems[i].qty=$scope.selectedItems[i].qty+1;
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
                                warehouse:0
                            };
                            $scope.selectedItems.push(obj);
                            break;
                        }
                    }


                }

                //var itemss=$scope.selectedItems;
                console.log($scope.selectedItems);
                console.log($scope.selectedItem);
                console.log($scope.items[0]);
            };
            $scope.removeItem=function(index){
                $scope.selectedItems.splice(index, 1);
                //var itemss=$scope.selectedItems;
                console.log($scope.selectedItems);
            };
            $scope.submitItem=function(){
                //console.log("hey");
                $http({
                    method : "post",
                    url : "/item/create",
                    data:{'name':$scope.item_name,'qty':$scope.item_qty,'alert_qty':$scope.item_alert_qty,'category_id':$scope.category_id}
                }).then(function Succes(response) {
                    $scope.item_name='';$scope.item_qty='';$scope.item_alert_qty='';$scope.category_id='';
                    location.reload();
                    console.log(response.data);
                    //console.log($scope.submittedData);
                }, function Error(response) {
                    console.log(response.data);
                });

            };

            $scope.submitCategory=function(){
                //console.log("hey");
                $http({
                    method : "post",
                    url : "/category/create",
                    data:{'name':$scope.category_name}
                }).then(function Succes(response) {
                    $scope.category_name='';
                    location.reload();
                    console.log(response.data);
                    //console.log($scope.submittedData);
                }, function Error(response) {
                    console.log(response.data);
                });

            };



            $scope.submittedData={
                ship_name:'',
                items:$scope.selectedItems,
                origin_country:''
            };


            $scope.submit=function(){
                $scope.submittedData.items=$scope.selectedItems;
                //console.log($scope.submittedData);
                $http({
                    method : "POST",
                    url : "/purchase",
                    data:$scope.submittedData
                }).then(function Succes(response) {
                    $scope.success=true;$scope.error=false;$scope.selectedItems=[];$scope.selectedItem=0;
                    //generate the items again to update quantity
                    $http.get('/items').then(function(result){
                        $scope.items=result.data;
                    });
                    //hide success alert after 60 seconds
                    $timeout(function () {
                        $scope.success=false;
                        $scope.selectedPlateNo='';
                        $scope.selectedNote="";
                    }, 5000);
                    console.log(response.data);
                }, function Error(response) {
                    $scope.error=true;$scope.success=false;
                    console.log(response.data);
                });
            }

        });
    </script>

@endsection

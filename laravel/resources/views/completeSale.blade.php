@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Complete Sale</div>
                    <div class="panel-body" ng-controller="complete">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible" ng-show="success" ng-cloak>
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <ol>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ol>

                                <strong>Success!</strong> Sales has been added successfully.
                            </div>
                        @endif
                        @include('layouts.complete');
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var updateOnBoard=function(id){
            var qty=document.getElementById ("qty"+id).innerText;
            var on_board=document.getElementById('on_board'+id).value;
            var old_on_board=document.getElementById ("old_on_board"+id).innerText;
            var in_stock=document.getElementById('in_stock'+id).value;
            document.getElementById('on_board'+id).value=parseInt(qty)-parseInt(old_on_board)-parseInt(in_stock);
            //alert(on_board);
            //$('#on_board'+id).value(11);
        };
        var updateInStock=function(id){
            var qty=document.getElementById ("qty"+id).innerText;

            var on_board=document.getElementById('on_board'+id).value;
            var in_stock=document.getElementById('in_stock'+id).value;
            var old_on_board=document.getElementById ("old_on_board"+id).innerText;
            document.getElementById('in_stock'+id).value=parseInt(qty)-parseInt(old_on_board)-parseInt(on_board);
            //alert(on_board);
            //$('#on_board'+id).value(11);
        };
        myApp=angular.module('myApp',['angular-loading-bar']);
        myApp.config(function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });

        myApp.controller('complete',function($scope,$http,$timeout){
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
                                qty:1,
                                stock:$scope.items[i].qty,
                                on_board:1,
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
            $http.get('/customers').then(function(result){
                $scope.customers=result.data;
            });
            $http.get('/drivers').then(function(result){
                $scope.drivers=result.data;
            });
            $http.get('/branches').then(function(result){
                $scope.branches=result.data;
            });
            //get the selected items



            $scope.submittedData={
                customer_id:'',
                items:$scope.selectedItems,
                driver_id:0,
                ordered_by:'',
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
                    $timeout(function () {
                        $scope.success=false;
                        $scope.selectedPlateNo='';
                        $scope.selectedNote="";
                    }, 6000);

                    console.log(response.data);
                    //console.log($scope.submittedData);
                }, function Error(response) {
                    $scope.error=true;$scope.success=false;
                    console.log(response.data);
                });
            }
            $scope.update_on_board=function(key){
                //$scope.selectedItems[key].on_board=$scope.selectedItems[key].on_board-$scope.selectedItems[key].in_stock;
                console.log($scope.selectedItems[key].on_board);
            }
            $scope.calculateRemaining=function(key){
                $scope.selectedItems[key].in_stock=$scope.selectedItems[key].qty-$scope.selectedItems[key].on_board
            }




        });
    </script>

@endsection


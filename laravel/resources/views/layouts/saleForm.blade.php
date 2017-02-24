<form class="form-horizontal" role="form" method="POST" action="" name="saleForm" onsubmit="return false">
    {{ csrf_field() }}
    <div class="form-group" ng-class="{'has-error': saleForm.customer_id.$invalid && !saleForm.customer_id.$pristine}">
        <label for="name" class="col-md-4 control-label">Customer:</label>

        <div class="col-md-6">
            <select id="customer" ui-select2 class="form-control" name="customer_id" ng-change="get_customer_branch()"  ng-model="submittedData.customer_id" autofocus>
                <option value="">Select customer</option>
                @foreach($customers as $customer)
                    <option value="{{$customer->id}}" data-branch="{{$customer->branch_id}}">{{$customer->name}}</option>
                @endforeach
            </select>
                <span class="help-block" ng-show="saleForm.customer_id.$invalid && !saleForm.customer_id.$pristine">
                                        <strong>[[saleForm.customer_id.$valid]]</strong>
                                    </span>

        </div>
        <div class="col-md-1"><button class="btn btn-default" ng-click="" data-toggle="modal" data-target="#cmodel">New</button></div>
    </div>

    <div class="form-group" ng-class="{'has-error': saleForm.item_id.$invalid && !saleForm.item_id.$pristine}">
        <label for="name" class="col-md-4 control-label">Item:</label>

        <div class="col-md-5">
            <!--<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>-->
            <select ui-select2 class="form-control select" name="item_id"   ng-model="selectedItem" id="">
                @foreach($items as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>


                <span class="help-block" ng-show="saleForm.item_id.$invalid && !saleForm.item_id.$pristine">
                                        <strong>Item is required</strong>
                                    </span>

        </div>
        <div class="col-md-1">
            <button class="btn btn-primary" ng-click="addItem()" onclick="return false">Add</button>
        </div>

    </div>
    <table class="table table-bordered col-md-6">
        <caption>Sale List</caption>
        <thead>
        <tr>
            <th>Item Name</th> <th>Qty</th><th>Shipped</th><th>Remaining</th><th>In Stock</th> <th>Warehouse</th><th></th>
        </tr>

        </thead>
        <tbody >

        <tr ng-repeat="(key,value) in selectedItems track by $index">
            <td >[[value.name]]</td>
            <td>
                <input type="text" class="form-control" ng-model="selectedItems[key].qty" ng-change="update_on_board(key)">
            </td>
            <td>
                <input type="text" class="form-control" ng-model="selectedItems[key].on_board" ng-change="calculateRemaining(key)">
            </td>
            <td>
                <input type="text" class="form-control" ng-model="selectedItems[key].in_stock" ng-change="update_on_board(key)">
            </td>
            <td>[[value.stock | number ]]</td>
            <td>
                <select class="form-control" ng-model="selectedItems[key].warehouse">
                    @foreach($warehouses as $warehouse)
                        <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                    @endforeach
                </select>
            </td>
            <td><button class="btn btn-danger" ng-click="removeItem(key)"><span class="glyphicon glyphicon-trash"></span></button></td>
        </tr>
        </tbody>
    </table>

    <div class="form-group" ng-class="{'has-error': saleForm.driver_id.$invalid && !saleForm.driver_id.$pristine}">
        <label for="name" class="col-md-4 control-label">Driver:</label>

        <div class="col-md-6">
            <!--<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>-->
            <select ui-select2 class="form-control select" name="driver_id"   ng-model="submittedData.driver_id" >
                <option value="">Select Driver</option>
                @foreach($drivers as $driver)
                    <option value="{{$driver->id}}">{{$driver->name}}</option>
                @endforeach
            </select>

                <span class="help-block" ng-show="saleForm.driver_id.$invalid && !saleForm.driver_id.$pristine">
                                        <strong>Driver by is required</strong>
                                    </span>
        </div>
        <div class="col-md-1"><button class="btn btn-default" ng-click="" data-toggle="modal" data-target="#dmodel">New</button></div>
    </div>

    <div class="form-group" ng-class="{'has-error': saleForm.ordered_by.$invalid && !saleForm.ordered_by.$pristine}">
        <label for="name" class="col-md-4 control-label">Order By:</label>

        <div class="col-md-6">
            <!--<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>-->
            <select size="3" class="form-control select" name="ordered_by" ng-model="submittedData.ordered_by">
                @foreach($branches as $branch)
                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach
            </select>

            <span class="help-block" ng-show="saleForm.ordered_by.$invalid && !saleForm.ordered_by.$pristine">
                <strong>Order by is required</strong>
            </span>

        </div>
        <div class="col-md-1"><button class="btn btn-default" data-toggle="modal" data-target="#bmodal">New</button></div>
    </div>

    <div class="form-group" ng-class="{'has-error': saleForm.plate_no.$invalid && !saleForm.plate_no.$pristine}">
        <label for="name" class="col-md-4 control-label">Plate No:</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control" name="plate_no" value="{{ old('name') }}" ng-model="submittedData.plate_no" required>
                <span class="help-block" ng-show="saleForm.plate_no.$invalid && !saleForm.plate_no.$pristine">
                                        <strong>Plate No is required</strong>
                                    </span>

        </div>
    </div>


    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="col-md-4 control-label">Note:</label>

        <div class="col-md-6">
            <!--<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>-->
            <textarea class="form-control" ng-model="submittedData.note" name="note"></textarea>

            @if ($errors->has('name'))
                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary" ng-click="submit()" ng-disabled="saleForm.$invalid" onclick="false">
                submit
            </button>
        </div>
    </div>
</form>
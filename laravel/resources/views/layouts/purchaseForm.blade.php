<form class="form-horizontal" role="form" method="POST" action="" name="purchaseForm" onsubmit="return false">
    {{ csrf_field() }}
    <div class="form-group" ng-class="{'has-error': purchaseForm.ship_name.$invalid && !purchaseForm.ship_name.$pristine}">
        <label for="name" class="col-md-4 control-label">Ship Name:</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control" name="ship_name" value="{{ old('name') }}" ng-model="submittedData.ship_name" required>


                <span class="help-block" ng-show="purchaseForm.ship_name.$invalid && !purchaseForm.ship_name.$pristine">
                                        <strong>[[purchaseForm.customer_id.$valid]]</strong>
                                    </span>

        </div>

    </div>

    <div class="form-group" ng-class="{'has-error': purchaseForm.origin_country.$invalid && !purchaseForm.origin_country.$pristine}">
        <label for="name" class="col-md-4 control-label">Origin Country:</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control" name="origin_country" value="{{ old('name') }}" ng-model="submittedData.origin_country" required>


                <span class="help-block" ng-show="purchaseForm.origin_country.$invalid && !purchaseForm.origin_country.$pristine">
                                        <strong>[[purchaseForm.customer_id.$valid]]</strong>
                                    </span>

        </div>

    </div>


    <div class="form-group" ng-class="{'has-error': purchaseForm.item_id.$invalid && !purchaseForm.item_id.$pristine}">
        <label for="name" class="col-md-4 control-label">Item:</label>

        <div class="col-md-5">
            <!--<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>-->
            <select class="form-control select" name="item_id"   ng-model="selectedItem" ui-select2>
                <option  value=""></option>
                <option ng-repeat="(key,value) in items " value="[[value.id]]">[[value.name]]</option>
            </select>
                <span class="help-block" ng-show="purchaseForm.item_id.$invalid && !purchaseForm.item_id.$pristine">
                                        <strong>Item is required</strong>
                                    </span>


        </div>
        <div class="col-md-1"><button class="btn btn-primary" ng-click="addItem()" onclick="return false">Add</button></div>
        <div class="col-md-1">
            <button class="btn btn-default"  data-toggle="modal" data-target="#itemModel">New</button>
        </div><br>

    </div>
    <div class="col-md-12 col-md-offset-9">
        <button class="btn btn-default"  data-toggle="modal" data-target="#categorymodal">New Category</button>
    </div>

    <table class="table table-bordered col-md-6">
        <caption>Purchase List</caption>
        <thead>
        <tr>
            <th>Item Name</th> <th>Qty</th><th>In Stock</th> <th>Warehouse</th><th></th>
        </tr>

        </thead>
        <tbody >
        <tr ng-repeat="(key,value) in selectedItems track by $index">
            <td >[[value.name]]</td>
            <td>
                <input type="text" class="form-control" ng-model="selectedItems[key].qty">
            </td>
            <td >[[value.stock]]</td>
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


    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary" ng-click="submit()" ng-disabled="purchaseForm.$invalid" onclick="false">
                submit
            </button >
        </div>
    </div>
</form>
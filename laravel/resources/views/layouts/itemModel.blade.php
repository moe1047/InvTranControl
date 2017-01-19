<!-- Item Modal -->
<div class="modal fade" id="itemModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Item</h4>
            </div>
            <form ng-submit="submitItem()" name="itemForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Item Name:</label>
                        <input type="text" class="form-control" id="recipient-name" ng-model="item_name" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Quantity:</label>
                        <input type="text" class="form-control" id="recipient-name" ng-model="item_qty"  required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Alert Quantity:</label>
                        <input type="text" class="form-control" id="recipient-name" ng-model="item_alert_qty"  required>
                    </div>
                    <div class="form-group">
                        <!--<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>-->
                        <select  class="form-control select" name="category_id"   ng-model="category_id" id="">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" ng-disabled="itemForm.$invalid">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
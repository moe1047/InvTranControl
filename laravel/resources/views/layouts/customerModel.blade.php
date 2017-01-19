<!-- Customer Modal -->
<div class="modal fade" id="cmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Customer</h4>
            </div>
            <form ng-submit="submitCustomer()" name="customerForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Customer Name:</label>
                        <input type="text" class="form-control" id="recipient-name" ng-model="customer_name" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Tell:</label>
                        <input type="text" class="form-control" id="recipient-name" ng-model="customer_no" >
                    </div>
                    <input type="hidden" value="customer">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" ng-disabled="customerForm.$invalid">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Change Password Modal -->
<div class="modal fade" id="cPasswordmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Customer</h4>
            </div>
            <form ng-submit="submitPass()" name="customerForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Old Password:</label>
                        <input type="password" class="form-control" id="recipient-name" required ng-model="old_pass">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">New Password:</label>
                        <input type="password" class="form-control" id="recipient-name"  required ng-model="new_pass">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label" >Confirm Password:</label>
                        <input type="password" class="form-control" id="recipient-name" ng-model="c_password" required>
                    </div>

                    <input type="hidden" value="{{Auth::user()->id}}" name="user_id" ng-model="user_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" ng-disabled="customerForm.$invalid">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
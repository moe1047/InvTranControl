<!-- Driver Modal -->
<div class="modal fade" id="dmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Driver</h4>
            </div>
            <form ng-submit="submitDriver()" name="driverForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Driver Name:</label>
                        <input type="text" class="form-control" id="recipient-name" ng-model="driver_name" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Tell:</label>
                        <input type="text" class="form-control" id="recipient-name" ng-model="driver_no" >
                    </div>
                    <input type="hidden" value="driver">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" ng-disabled="driverForm.$invalid">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
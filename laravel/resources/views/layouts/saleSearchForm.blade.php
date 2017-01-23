<form name="searchForm" action="{{url('sale/search')}}" method="get">
    {{ csrf_field() }}
    <div class="panel panel-default col-md-12">
        <div class="panel-body">
            <div class="form-group col-md-3">
                <label class="control-label">Sale Id</label>
                <input type="text" class="form-control"  ng-model="submittedData.sale_id" name="sale_id" >
            </div>
            <div class="form-group col-md-3 ">
                <label class="control-label">From</label>
                <input type="text" class="form-control date" ng-model="submittedData.from"
                       uib-datepicker-popup="yyyy-MM-dd"
                       is-open="popup1.opened"
                       datepicker-options="dateOptions"

                       close-text="Close"
                       alt-input-formats="altInputFormats"
                       ng-click="open1()"  name="from">
            </div>
            <div class="form-group col-md-3 ">
                <label class="control-label">To</label>
                <input type="text" class="form-control date" ng-model="submittedData.to"
                       uib-datepicker-popup="yyyy-MM-dd"
                       ng-model="dt"
                       is-open="popup2.opened"
                       datepicker-options="dateOptions"

                       close-text="Close"
                       alt-input-formats="altInputFormats"
                       ng-click="open2()"  name="to">
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Driver</label>
                <select ui-select2 class="form-control" name="driver_id" ng-change="check()"  ng-model="submittedData.driver_id" autofocus>
                    <option value="" selected>All</option>
                    @foreach($drivers as $driver)
                        <option value="{{$driver->id}}">{{$driver->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Customer</label>
                <select ui-select2 class="form-control" name="customer_id" ng-change="check()"  ng-model="submittedData.customer_id" autofocus>
                    <option value="" selected>All</option>
                    @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Item</label>
                <select ui-select2 class="form-control" name="item_id"  ng-model="submittedData.item_id" autofocus>
                    <option value="" selected>All</option>
                    @foreach($items as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Branch</label>
                <select ui-select2 class="form-control" name="branch_id" ng-change="check()"  ng-model="submittedData.branch_id" autofocus>
                    <option value="" selected>All</option>
                    @foreach($branches as $branch)
                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Plate No</label>
                <input type="text" class="form-control" name="plate_no" ng-model="submittedData.plate_no">
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">status</label>
                <select  class="form-control" name="status" >
                    <option value="" selected>All</option>
                    <option value="completed" >Completed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                @if(Auth::user()->role=='owner' or Auth::user()->role=='sales')
                    <input type="submit" class="btn btn-primary" value="Search"   name="search">
                @endif

                <input type="submit" class="btn btn-primary" value="Report" name="report">
            </div>
        </div>
    </div>
</form>

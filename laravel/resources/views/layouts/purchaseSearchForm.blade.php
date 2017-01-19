<form name="searchForm" action="{{url('purchase/search')}}" method="get">
    {{ csrf_field() }}
    <div class="panel panel-default col-md-12">
        <div class="panel-body">
            <div class="form-group col-md-3">
                <label class="control-label">Purchase Id</label>
                <input type="text" class="form-control"  name="purchase_id" >
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
                <label class="control-label">Ship Name</label>
                <input type="text" class="form-control"   name="ship_name" >
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Origin Country</label>
                <input type="text" class="form-control"   name="origin_country" >
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Item</label>
                <select ui-select2 class="form-control" name="item_id" ng-model="submittedData.item_id"  autofocus>
                    <option value="" selected>All</option>
                    @foreach($items as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-3">
                <input type="submit" class="btn btn-primary" value="Search"   name="search">
                <input type="submit" class="btn btn-primary" value="Report" name="report">
            </div>
        </div>
    </div>
</form>

<form action="{{ url('sale/complete') }}" method="post">
    {{ csrf_field() }}
    <table class="table table-bordered col-md-8">
        <caption>Update Sale Quantity</caption>
        <thead>
        <tr>
            <th>Item Name</th> <th>Qty</th><th>Sent</th><th>Shipped</th><th>Remaining</th><th>in Stock</th>
        </tr>

        </thead>
        <tbody>

            @foreach($sale->saleItems as $saleItem)
                @if($saleItem->in_stock != 0)

                    <tr>
                        <td>{{$saleItem->Item->name}}</td>
                        <td>
                            {{$saleItem->qty}}
                        </td>
                        <td>
                            {{$saleItem->on_board}}
                        </td>
                        <td>
                            <input type="text" class="form-control" value="{{$saleItem->in_stock}}" name="items[{{$saleItem->id}}][on_board]"  >
                        </td>
                        <td>
                            <input type="text" class="form-control" value="0"  name="items[{{$saleItem->id}}][in_stock]">
                        </td>

                        <td>{{$saleItem->Item->qty}}</td>
                        <input type="hidden" class="form-control" value="{{$saleItem->qty}}"  name="items[{{$saleItem->id}}][qty]">
                        <input type="hidden" class="form-control" value="{{$saleItem->on_board}}"  name="items[{{$saleItem->id}}][sent]">
                    </tr>
                @endif
            @endforeach
            <input type="hidden" class="form-control" value="{{$sale->id}}" name="sale_id">
            <div class="form-group col-md-4">
                <label class="control-label">Driver</label>
                <select ui-select2 class="form-control" name="driver_id" ng-model="submittedData.driver_id" autofocus>
                    @foreach($drivers as $driver)
                        <option value="{{$driver->id}}">{{$driver->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label class="control-label">Plate No</label>
                <input type="text" class="form-control" name="plate_no" required>
            </div>
            <div class="form-group col-md-4">
                <label class="control-label">Note</label>
                <input type="text" class="form-control" name="note">
            </div>


        </tbody>
    </table>

    <div class="form-group">
        <div class="col-md-6 ">
            <button type="submit" class="btn btn-primary" ng-click="submit()" ng-disabled="saleForm.$invalid" >
                Update
            </button >
        </div>
    </div>
</form>
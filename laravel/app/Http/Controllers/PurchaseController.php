<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\ItemMovement;
use App\ItemWarehouse;
use App\Purchase;
use App\PurchaseItems;
use App\Warehouse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $purchases= Purchase::paginate(10);
        $items=\App\Item::all();
        return view("allPurchases",compact('purchases','items'));
    }
    public function search(\Illuminate\Http\Request $request)
    {
        $from=Carbon::parse($request->input('from'))->toDateString();
        $to=Carbon::parse($request->input('to'))->toDateString();
        if($request->input('report')!=""){
            $purchases=Purchase::when($request->has('from')&&$request->has('to'),function($builder) use ($request,$from,$to){
                return $builder->whereBetween('purchased_date',array($from,$to));
            })
                ->when($request->has('purchase_id'),function($builder) use ($request){
                    return $builder->where('id',$request->input('purchase_id'));
                })->when($request->has('ship_name'),function($builder) use ($request){
                    return $builder->where('ship_name','like',$request->input('ship_name'));
                })->when($request->has('origin_country'),function($builder) use ($request){
                    return $builder->where('origin_country','like',$request->input('origin_country'));
                })->when($request->has('item_id'),function($builder) use ($request){
                    return $builder->whereHas('purchaseItems',function($query) use ($request){
                        $query->where('item_id',$request->input('item_id'));
                    });
                })->orderBy('id','desc')->get();
            $item_id=$request->input('item_id');//to filter items
            return view('purchaseSummary',compact('purchases','from','to','item_id'));

        }else{
            $purchases=Purchase::when($request->has('from')&&$request->has('to'),function($builder) use ($request,$from,$to){
                return $builder->whereBetween('purchased_date',array($from,$to));
            })
                ->when($request->has('purchase_id'),function($builder) use ($request){
                    return $builder->where('id',$request->input('purchase_id'));
                })->when($request->has('ship_name'),function($builder) use ($request){
                    return $builder->where('ship_name',$request->input('ship_name'));
                })->when($request->has('origin_country'),function($builder) use ($request){
                    return $builder->where('origin_country',$request->input('origin_country'));
                })->when($request->has('item_id'),function($builder) use ($request){
                    return $builder->whereHas('purchaseItems',function($query) use ($request){
                        $query->where('item_id',$request->input('item_id'));
                    });
                })->orderBy('id','desc')->paginate(10);
            //$purchases= Purchase::paginate(10);
            $items=\App\Item::all();
            return view("allPurchases",compact('purchases','items'));

        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //for Item registration
        $categories=Category::all();
        $warehouses=Warehouse::all();
        return view("purchase",compact('categories','warehouses'));
    }

    public function delete($id)
    {
        DB::transaction(function($id) use ($id)
        {
            $purchase=Purchase::find($id);
            //$sale_id=$sale->id;
            //$sale->delete();
            foreach($purchase->purchaseItems as $purchaseItem){
                PurchaseItems::where('purchase_id',$purchaseItem->id)->delete();
                //sub quantity from items
                //get previous qty
                $previous_qty=Item::find($purchaseItem->item->id)->qty;
                Item::where('id',$purchaseItem->item->id)->update(['qty'=>(int)$previous_qty-(int)$purchaseItem->qty]);
                //add quantity back to item warehouse
                $itemWarehouse=ItemWarehouse::find($purchaseItem->ItemWarehouse->id);
                $itemWarehouse->update(['qty'=>(int)$itemWarehouse->qty-(int)$purchaseItem->qty]);
                ItemMovement::create(['tran_type'=>'delete_purchase','qty'=>(int)$purchaseItem->qty,
                    'in_stock'=>(int)$previous_qty-(int)$purchaseItem->qty,'item_id'=>$purchaseItem->item_id,'item_warehouse_id'=>$purchaseItem->ItemWarehouse->id]);

                //delete from saleItem
                $purchaseItem->delete();
            }
            $purchase->delete();


        });
        return response('Purchase been deleted successfully');
        //delete from sale
        //delete from saleItem
        //delete from saleItemTransaction

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $this->validate($request, [
            'ship_name' => 'required',
            'origin_country' => 'required',
            'items' => 'required',
        ]);

        DB::transaction(function($request) use ($request)
        {
            //get items
            $purchaseItems= $request->input('items');

                //get if warehouse is empty
            foreach($purchaseItems as $purchaseItem){
                if($purchaseItem['warehouse'] =="" ){
                    throw new \Exception('Warehouse Shouldnt be empty');
                    break;

                }
            }


            //submit sale
            $purchase=Purchase::create(['ship_name'=>$request->input('ship_name'),'origin_country'=>$request->input('origin_country'),
                'purchased_date'=>Carbon::now()->toDateString()]);
            //submit sale items
            foreach($purchaseItems as $purchaseItem){
                $item_warehouse=ItemWarehouse::where('item_id',$purchaseItem['id'])->where('warehouse_id',$purchaseItem['warehouse'])->first();

                PurchaseItems::create(['purchase_id'=>$purchase->id,'qty'=>$purchaseItem['qty'],'item_id'=>$purchaseItem['id'],'item_warehouse_id'=>$item_warehouse->id]);
                //update item qty
                $qty=Item::find($purchaseItem['id'])->qty;

                $updatedItem=Item::where('id', $purchaseItem['id'])
                    ->update(['qty' => ((int)$qty+(int)$purchaseItem['qty'])]);

                //update item warehouse
                $item_warehouse_qty=$item_warehouse->qty;
                $item_warehouse->update(['qty'=>((int)$item_warehouse_qty+(int)$purchaseItem['qty'])]);

                ItemMovement::create(['tran_type'=>'add_purchase','qty'=>(int)$purchaseItem['qty'],
                    'tran_type_id'=>$purchase->id, 'in_stock'=>(int)$qty+(int)$purchaseItem['qty'],
                    'item_id'=>$purchaseItem['id'],'item_warehouse_id'=>$item_warehouse->id]);
            }
        });

        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $purchase=Purchase::find($id);
        return View('purchaseDetail',compact('purchase'));
    }
}

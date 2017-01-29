<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\ItemMovement;
use App\PurchaseItems;
use App\SaleItems;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',

        ]);
        DB::transaction(function($request) use ($request)
        {

                $item=Item::create(['name'=>$request->input('name'),'qty'=>$request->input('qty'),'alert_qty'=>$request->input('alert_qty'),'category_id'=>$request->input('category_id')]);
                ItemMovement::create(['tran_type'=>'opening_balance','qty'=>$item->qty,'in_stock'=>$item->qty,'item_id'=>$item->id]);
        });
        //People::find($id)->delete();
    }//createCategory
    public function search_movement()
    {
        $items=Item::all();
        return view('searchItemMovement',compact('items'));
    }
    public function movement_report(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required',

        ]);
        $from=Carbon::parse($request->input('from'))->toDateString();
        $to=Carbon::parse($request->input('to'))->toDateString();
        $itemMovements=ItemMovement::when($request->has('from')&&$request->has('to'),function($builder) use ($request,$from,$to){
            return $builder->whereBetween('created_at',array($from,$to));
        })
            ->when($request->has('item_id'),function($builder) use ($request){
                return $builder->where('item_id',$request->input('item_id'));
            })->orderBy('created_at','asc')->get();
        $item_name=Item::find($request->input('item_id'))->name;
        return view('itemMovementSummary',compact('from','to','itemMovements','item_name'));
    }
    public function createCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
        ]);

        try{
            return Category::create(['name'=>$request->input('name')]);
        }catch (\Exception $e){
            return response($e->getMessage(),500);
        }

        //People::find($id)->delete();
    }
    public function categories()
    {
        return Category::all();
    }
    public function category_edit($id)
    {
        $category=Category::find($id);
        return view('editCategory',compact('category'));
    }//category_update
    public function category_update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',

        ]);
        Category::find($id)->update(['name'=>$request->input('name')]);
        return redirect('people');
    }
    public function edit($id)
    {
        $item=Item::find($id);
        $categories=Category::all()->pluck('name','id');
        return view('editItem',compact('item','categories'));
    }
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',

        ]);
        Item::find($id)->update(['name'=>$request->input('name'),'alert_qty'=>$request->input('alert_qty')]);
        return redirect('people');
    }
    public function all()
    {
        return Item::all()->orderBy('name', 'asc');
        //People::find($id)->delete();
    }
    public function summary()
    {
        $today=Carbon::today()->toDateString();
        $categories=Category::orderBy('name')->get();
        return view('inventoryList',compact('categories','today'));
        //People::find($id)->delete();
    }
    public function delete($id)
    {
        try{
            $item=Item::find($id);
            if(!(SaleItems::where('item_id',$item->id)->count()>0 || PurchaseItems::where('item_id',$item->id)->count()>0)){
                Item::find($id)->delete();
                return response("A Item has been deleted", 201);
            }else{
                throw new \Exception('This Item is in sales/Purchase Transaction');
            }

        }catch (\Exception $e){
            //return response()->json(['message' => $e->getMessage()], 500 );
            return response($e->getMessage(), 500);
        };
    }
}

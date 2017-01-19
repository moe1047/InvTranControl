<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\SaleItems;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',

        ]);

        try{
            return Item::create(['name'=>$request->input('name'),'qty'=>$request->input('qty'),'alert_qty'=>$request->input('alert_qty'),'category_id'=>$request->input('category_id')]);
        }catch (\Exception $e){
            return response($e->getMessage(),500);
        }

        //People::find($id)->delete();
    }//createCategory
    public function createCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',

        ]);

        try{
            return Category::create(['name'=>$request->input('name')]);
        }catch (\Exception $e){
            return response($e->getMessage(),500);
        }

        //People::find($id)->delete();
    }
    public function all()
    {
        return Item::all();
        //People::find($id)->delete();
    }
    public function summary()
    {
        $categories=Category::all();
        return view('inventoryList',compact('categories'));
        //People::find($id)->delete();
    }
    public function delete($id)
    {
        try{
            $item=Item::find($id);
            if(!(SaleItems::where('item_id',$item->id)->count()>0)){
                Item::find($id)->delete();
                return response("A Item has been deleted", 201);
            }else{
                throw new \Exception('This Item is in sales Transaction');
            }
        }catch (\Exception $e){
            //return response()->json(['message' => $e->getMessage()], 500 );
            return response($e->getMessage(), 500);
        };
    }
}

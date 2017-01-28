<?php

namespace App\Http\Controllers;

use App\People;
use App\Sale;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('allPeople');
    }
    public function customers()
    {
        return People::where('type','customer')->orderBy('name')->get();
    }
    public function drivers()
    {
        return People::where('type','driver')->orderBy('name')->get();
    }
    public function branches()
    {
        return People::where('type','branch')->orderBy('name')->get();
    }//postCustomer

    public function postCustomer(Request $request)
    {
        try{
            return People::create(['name'=>$request->input('name'),'no'=>$request->input('no'),'type'=>'customer']);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()]);

        }

    }
    public function postDriver(Request $request)
    {
        try{
            return People::create(['name'=>$request->input('name'),'no'=>$request->input('no'),'type'=>'driver']);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()]);

        }

    }
    public function postBranch(Request $request)
    {
        try{
            return People::create(['name'=>$request->input('name'),'no'=>$request->input('no'),'type'=>'branch']);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()]);

        }

    }


    public function delete($id)
    {

        try{
            $people=People::find($id);
            $type=People::find($id)->type;
            if($type=='branch'){
                $type='ordered_by';
            }else{
                $type=trim($people->type).'_id';
            }
            if(!(Sale::where($type,$people->id)->count()>0)){
                People::find($id)->delete();
                return response("A person has been deleted", 201);
            }else{
                throw new \Exception('This Person is involved in a Transaction');
            }
        }catch (\Exception $e){
            //return response()->json(['message' => $e->getMessage()], 500 );
            return response($e->getMessage(), 500);
        }

        //People::find($id)->delete();
    }
    public function edit($id)
    {
        $people=People::find($id);
        return view('editPeople',compact('people'));
    }
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',

        ]);
        People::find($id)->update(['name'=>$request->input('name'),'no'=>$request->input('no')]);
        return redirect('people');
    }


}

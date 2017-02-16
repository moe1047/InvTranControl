<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemMovement;
use App\People;
use App\Sale;
use App\SaleItems;
use App\SaleItemTran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Request;
use SebastianBergmann\ObjectEnumerator\Exception;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function summry(){
        return view("summary",compact('sales'));
    }
    public function edit($id){
        $customers=\App\People::where('type','customer')->get()->pluck('name','id');
        $drivers=\App\People::where('type','driver')->get()->pluck('name','id');
        $branches=\App\People::where('type','branch')->get()->pluck('name','id');
        $sale=Sale::find($id);
        return view("editSale",compact('sale','customers','drivers','branches'));
    }
    public function update(\Illuminate\Http\Request $request,$id){
        $this->validate($request, [
            'customer_id' => 'required',
            'driver_id' => 'required',
            'ordered_by' => 'required',
            'plate_no' => 'required',

        ]);
        Sale::find($id)->update(['customer_id'=>$request->input('customer_id'),
            'driver_id'=>$request->input('driver_id'),
            'ordered_by'=>$request->input('ordered_by'),
            'plate_no'=>$request->input('plate_no')
        ]);
        return redirect('sale');
    }
    public function index(\Illuminate\Http\Request $request)
    {
        $customers=\App\People::where('type','customer')->get(['name','id']);
        $drivers=\App\People::where('type','driver')->get(['name','id']);
        $branches=\App\People::where('type','branch')->get(['name','id']);
        $items=\App\Item::all();
        $sales= Sale::orderBy('id','desc')->paginate(10);
        return view("layouts.OnlySaleList",compact('sales','customers','drivers','branches','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers=\App\People::where('type','customer')->get(['name','id','branch_id']);
        $drivers=\App\People::where('type','driver')->get(['name','id']);
        $branches=\App\People::where('type','branch')->orderBy('name')->get(['name','id']);
        $items=\App\Item::all();
        return view("sale",compact('sales','customers','drivers','branches','items'));
    }
    public function printt($id)
    {
        $sale=Sale::find($id);
        return view("receipt",compact('sale'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Illuminate\Http\Request $request)
    {
        //validate
        $this->validate($request, [
            'customer_id' => 'required|numeric',
            'driver_id' => 'required|numeric',
            'ordered_by' => 'required|numeric',
            'items' => 'required',
        ]);
        $saleID=0;

        DB::transaction(function($request) use ($request,$saleID)
        {
            global $saleID;
            //get items
            $sale_status="completed";
            $saleItems= $request->input('items');

            //get if there is pending sales
            foreach($saleItems as $saleItem){
                if((int)$saleItem['in_stock'] > 0){
                    $sale_status="pending";
                    break;
                }
            }
            //get if in_stock + on_board= quantity
            foreach($saleItems as $saleItem){
                if((int)$saleItem['in_stock'] + (int)$saleItem['on_board'] !=(int)$saleItem['qty'] ){
                    throw new \Exception('In stock + On Board should be = total Quant  ity');
                    break;

                }
            }

            //submit sale
            $sale=Sale::create(['driver_id' => $request->input('driver_id'),'customer_id'=>$request->input('customer_id'),'ordered_by'=>$request->input('ordered_by'),'plate_no'=>$request->input('plate_no'),'note'=>$request->input('note'),
                'sale_date'=>Carbon::now()->toDateString(),'total_items'=>count($saleItems),'status'=>$sale_status,'created_by'=>Auth::user()->id]);
            $saleID=$sale->id;


            //submit sale items
            foreach($saleItems as $saleItem){
                $LastSaleItem=SaleItems::create(['sale_id'=>$sale->id,'qty'=>$saleItem['qty'],'item_id'=>$saleItem['id'],'on_board'=>$saleItem['on_board'],'in_stock'=>$saleItem['in_stock']]);
                //update item qty
                $qty=Item::find($saleItem['id'])->qty;
                Item::where('id', $saleItem['id'])
                    ->update(['qty' => ((int)$qty-(int)$saleItem['qty'])]);
                //add record to sale items Transactions
                SaleItemTran::create(['sale_item_id'=>$LastSaleItem->id,'on_board'=>$saleItem['on_board'],'in_stock'=>$saleItem['in_stock'],'driver_id'=>$request->input('driver_id'),'plate_no'=>$request->input('plate_no'),'note'=>$request->input('note')]);
                ItemMovement::create(['tran_type'=>'add_sale','qty'=>(int)$saleItem['qty'],'tran_type_id'=>$sale->id,
                    'in_stock'=>(int)$qty-(int)$saleItem['qty'],'item_id'=>$saleItem['id']]);

            }


        },5);//how to many times to re execute if a deadlock accures

        $saleID=Sale::orderBy('id', 'desc')->first()->id;
        return response($saleID);




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $sale=Sale::find($id);
        return View('saleDetail',compact('sale'));
    }
    public function delete($id)
    {
        DB::transaction(function($id) use ($id)
        {
            $sale=Sale::find($id);
            //$sale_id=$sale->id;
            //$sale->delete();
            foreach($sale->saleItems as $saleItem){
                SaleItemTran::where('sale_item_id',$saleItem->id)->delete();
                //add quantity back to items
                  //get previous qty
                $previous_qty=Item::find($saleItem->item->id)->qty;
                Item::where('id',$saleItem->item->id)->update(['qty'=>(int)$previous_qty+(int)$saleItem->qty]);
                ItemMovement::create(['tran_type'=>'delete_sale','qty'=>(int)$saleItem->qty,
                    'in_stock'=>(int)$previous_qty+(int)$saleItem->qty,'item_id'=>$saleItem->item_id]);

                //delete from saleItem
                $saleItem->delete();

            }
            $sale->delete();

        });
        return redirect('sale');
        //delete from sale
        //delete from saleItem
        //delete from saleItemTransaction

    }
    public function complete($id)
    {
        $drivers=\App\People::where('type','driver')->get(['name','id']);
        $sale=Sale::find($id);
        return View('completeSale',compact('sale','drivers'));
    }//completePost

    public function cancelRemaining($id)
    {
        $sale=Sale::find($id);
        DB::transaction(function($sale) use ($sale)
        {
            foreach($sale->saleItems as $saleItem){
                if($saleItem->in_stock >0){
                    $item=Item::find($saleItem->item_id);
                    Item::find($saleItem->item_id)->update(['qty'=>(int)$item->qty+(int)$saleItem->in_stock]);
                    SaleItems::find($saleItem->id)->update(['in_stock'=>0,'qty'=>(int)(SaleItems::find($saleItem->id)->qty)-(int)$saleItem->in_stock]);
                }


            }
            Sale::where('id', $sale->id)
                ->update(['status' => 'completed']);
        });

        return redirect('/sale');
    }

    public function completePost(\Illuminate\Http\Request $request)
    {
        //validate
        $this->validate($request, [
            'plate_no' => 'required|numeric',
            'driver_id' => 'required|numeric',
            'items' => 'required',
        ]);
        $item_list=[];
        DB::transaction(function($request) use (&$item_list,$request)
        {

            $sale_status="completed";
            foreach($request->input('items') as $id => $item){
                if((int)$item['in_stock'] + (int)$item['on_board']+ (int)$item['sent'] !=(int)$item['qty'] ){
                    throw new \Exception('In stock + On Board should be = total Quantity');
                    break;

                }

            }

            foreach($request->input('items') as $id => $item){
                $saleItem=SaleItems::find($id);
                //populate item_list for print
                $item_list[]=['name'=>$saleItem->item->name,
                    'on_board'=>(int)$item["on_board"],'in_stock'=>$item["in_stock"]
                    ,'plate_no'=>$request->input('plate_no'),'note'=>$request->input('note'),
                    'driver'=>People::find($request->input('driver_id'))->name,
                    'customer'=>$saleItem->sale->customer->name,
                    'branch'=>$saleItem->sale->orderedBy->name,
                    'sale_id'=>$saleItem->sale->id,
                    'sale_date'=>$saleItem->sale->sale_date,
                ];
                //update saleItems
                $previous_on_board=SaleItems::where('id',$id)->first()->on_board;
                SaleItems::where('id',$id)->update(['on_board'=>(int)$previous_on_board+(int)$item["on_board"],'in_stock'=>$item["in_stock"]]);
                //updatesale Items Transactions
                SaleItemTran::create(['sale_item_id'=>$id,'on_board'=>$item["on_board"],'in_stock'=>$item["in_stock"],'driver_id'=>$request->input('driver_id'),'plate_no'=>$request->input('plate_no'),'note'=>$request->input('note')]);
            }

            //update Sale status if there is no remaining
            foreach($request->input('items') as $id => $item){
                if((int)$item["in_stock"] > 0){
                    $sale_status="pending";
                    break;
                }
            }//if there is something left in the stock.

            if($sale_status=="completed"){
                Sale::where('id', $request->input('sale_id'))
                    ->update(['status' => 'completed']);
            }


        });

        return $this->completePrint($item_list);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function completePrint($itemss)
    {
        $items=$itemss;
        $customer=$items[0]['customer'];
        $sale_id=$items[0]['sale_id'];
        $driver=$items[0]['driver'];
        $date=$items[0]['sale_date'];
        $branch=$items[0]['branch'];
        $plate_no=$items[0]['plate_no'];
        $today=Carbon::today()->toDateString();

        return view('completeReciept',compact('items',
            'customer','sale_id','driver','date','branch'
        ,'plate_no','today'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(\Illuminate\Http\Request $request)
    {

        $from=Carbon::parse($request->input('from'))->toDateString();
        $to=Carbon::parse($request->input('to'))->toDateString();
        $sales=Sale::when($request->has('from')&&$request->has('to'),function($builder) use ($request,$from,$to){
            return $builder->whereBetween('sale_date',array($from,$to));
        })
            ->when($request->has('sale_id'),function($builder) use ($request){
                return $builder->where('id',$request->input('sale_id'));
            })
            ->when($request->has('customer_id'),function($builder) use ($request){
                return $builder->where('customer_id',$request->input('customer_id'));
            })
            ->when($request->has('branch_id'),function($builder) use ($request){
                return $builder->where('ordered_by',$request->input('branch_id'));
            })
            ->when($request->has('driver_id'),function($builder) use ($request){
                return $builder->where('driver_id',$request->input('driver_id'));
            })
            ->when($request->has('plate_no'),function($builder) use ($request){
                return $builder->where('plate_no',$request->input('plate_no'));
            })
            ->when($request->has('status'),function($builder) use ($request){
                return $builder->where('status',$request->input('status'));
            })
            ->when($request->has('item_id'),function($builder) use ($request){
                return $builder->whereHas('SaleItems',function($query) use ($request){
                    $query->where('item_id',$request->input('item_id'));
                });
            })->orderBy('id','desc')
            ->get();
        if($request->input('report')!=""){
            $item_id=$request->input('item_id');//to filter items

            return view('summary',compact('sales','from','to','item_id'));
        }else{
            $customers=\App\People::where('type','customer')->get(['name','id']);
            $drivers=\App\People::where('type','driver')->get(['name','id']);
            $branches=\App\People::where('type','branch')->get(['name','id']);
            $items=\App\Item::all();
            $sales=Sale::when($request->has('from')&&$request->has('to'),function($builder) use ($request,$from,$to){
                return $builder->whereBetween('sale_date',array($from,$to));
            })
                ->when($request->has('sale_id'),function($builder) use ($request){
                    return $builder->where('id',$request->input('sale_id'));
                })
                ->when($request->has('customer_id'),function($builder) use ($request){
                    return $builder->where('customer_id',$request->input('customer_id'));
                })
                ->when($request->has('branch_id'),function($builder) use ($request){
                    return $builder->where('ordered_by',$request->input('branch_id'));
                })
                ->when($request->has('driver_id'),function($builder) use ($request){
                    return $builder->where('driver_id',$request->input('driver_id'));
                })
                ->when($request->has('plate_no'),function($builder) use ($request){
                    return $builder->where('plate_no',$request->input('plate_no'));
                })
                ->when($request->has('status'),function($builder) use ($request){
                    return $builder->where('status',$request->input('status'));
                })
                ->when($request->has('item_id'),function($builder) use ($request){
                    return $builder->whereHas('SaleItems',function($query) use ($request){
                        $query->where('item_id',$request->input('item_id'));
                    });
                })->orderBy('id','desc')
                ->paginate(10);
            //return View('');
            return view("layouts.OnlySaleList",compact('sales','customers','drivers','branches','items','sales'));
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

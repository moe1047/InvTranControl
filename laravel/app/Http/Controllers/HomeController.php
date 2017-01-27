<?php

namespace App\Http\Controllers;

use App\Item;
use App\People;
use App\Purchase;
use App\Sale;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function users()
    {
        $users=User::all();
        return view('auth.allUsers',compact('users'));
    }
    public function activate($id)
    {
        User::find($id)
            ->update(['active' => 1]);
        return redirect('users/all');
    }
    public function deactivate($id)
    {
        User::find($id)
            ->update(['active' => 0]);
        return redirect('users/all');
    }
    public function delete($id)
    {
        if(!(Sale::where('created_by',$id)->count()>0)){
            $users=User::find($id);
            $users->delete();
            return redirect('users/all');
    }else{

            return redirect('users/all')->withErrors(['userInTran'=>User::find($id)->name.' is involved in sale Transaction']);
        }


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales=Sale::all()->count();
        $purchases=Purchase::all()->count();
        $pendingSales=Sale::where('status','pending')->count();
        //$pendingSales=Sale::all()->count();
        $items=Item::all();
        $alert_quantities=Item::whereRaw('items.qty <= items.alert_qty')->get();
        $itemsCount=Item::all()->count();
        $users=User::all()->count();
        $branches=People::where('type','branch')->count();
        $drivers=People::where('type','driver')->count();
        $customers=People::where('type','customer')->count();
        return view('home',compact('items','sales','pendingSales','purchases','itemsCount','purchases','branches','drivers','users','customers','alert_quantities'));
    }
}

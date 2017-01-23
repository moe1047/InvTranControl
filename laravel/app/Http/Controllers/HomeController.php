<?php

namespace App\Http\Controllers;

use App\Item;
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
        $items=Item::all();
        return view('home',compact('items'));
    }
}

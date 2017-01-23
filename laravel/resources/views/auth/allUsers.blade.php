@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default">
                    <div class="panel-heading">All Users</div>
                    <div class="panel-body" >
                        @if($errors->has('userInTran'))
                            <div class="alert alert-danger">{{ $errors->first('userInTran') }}</div>
                        @endif


                        <div id="items" class="col-xs-12">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th><th>Email</th><th>Action</th><th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr class="{{$user->active==1 ? '':'danger'}}">
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td >
                                            @if(Auth::user()->id != $user->id)
                                            @if($user->active==1)
                                                <a href="{{url("users/$user->id/deactivate")}}" class="btn btn-danger btn-sm" >Deactivate</a>
                                            @else
                                                <a href="{{url("users/$user->id/activate")}}" class="btn btn-success btn-sm">Activate</a>
                                            @endif
                                            @endif

                                        </td>
                                        <td>
                                            @if(Auth::user()->id != $user->id)
                                            <a href="{{url("users/$user->id/delete")}}" class="btn btn-danger btn-sm" onclick="return myFunction()">Delete</a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/sweetalert.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/sweetalert.css')}}">
    <script>
        function myFunction() {
            var confirmation =confirm("Are you Sure You want to delete this user?!");
            if(confirmation==true){
                return true
            }else{
                return false;
            }
        }


    </script>

@endsection


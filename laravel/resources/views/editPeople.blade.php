@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Form</div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="panel-body">
                        {!!Form::model($people, ['route' => ['peoplee.update', $people->id],'class'=>'form-horizontal'])!!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!!Form::label('name', 'Name:', ['class' => 'col-md-4 control-label'])!!}

                            <div class="col-md-6">
                                {!!Form::text('name',null, ['class'=>'form-control','required'])!!}

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!!Form::label('tell', 'Tell:', ['class' => 'col-md-4 control-label'])!!}

                            <div class="col-md-6">
                                {!!Form::text('no',null, ['class'=>'form-control'])!!}

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if($people->type=='customer')
                            <div class="form-group">
                                <!--<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>-->
                                {!!Form::label('tell', 'Branch:', ['class' => 'col-md-4 control-label'])!!}
                                <div class="col-md-6">
                                    <select  class="form-control select col-md-6" name="branch_id" id="" size="4" ng-model="customer_branch_id">
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}" {{$people->branch_id==$branch->id?'selected':''}}>{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


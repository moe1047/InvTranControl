@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Sale</div>
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
                        {!!Form::model($sale, ['route' => ['sale.update', $sale->id],'method'=>'PUT','class'=>'form-horizontal'])!!}
                        <div class="form-group{{ $errors->has('customer_id') ? ' has-error' : '' }}">
                            {!!Form::label('customer_id', 'Customer:', ['class' => 'col-md-4 control-label'])!!}

                            <div class="col-md-6">
                                {!!Form::select('customer_id', $customers,$sale->customer_id, ['class'=>'form-control','required','size'=>'4'])!!}
                                @if ($errors->has('customer_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('customer_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('driver_id') ? ' has-error' : '' }}">
                            {!!Form::label('driver_id', 'Driver:', ['class' => 'col-md-4 control-label'])!!}

                            <div class="col-md-6">
                                {!!Form::select('driver_id', $drivers,$sale->driver_id, ['class'=>'form-control','required','size'=>'4'])!!}
                                @if ($errors->has('driver_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('driver_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('ordered_by') ? ' has-error' : '' }}">
                            {!!Form::label('ordered_by', 'Prdered By:', ['class' => 'col-md-4 control-label'])!!}

                            <div class="col-md-6">
                                {!!Form::select('ordered_by', $branches,$sale->branch_id, ['class'=>'form-control','required','size'=>'4'])!!}
                                @if ($errors->has('ordered_by'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ordered_by') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('plate_no') ? ' has-error' : '' }}">
                            {!!Form::label('plate_no', 'Plate No:', ['class' => 'col-md-4 control-label'])!!}

                            <div class="col-md-6">
                                {!!Form::text('plate_no',null, ['class'=>'form-control','required'])!!}

                                @if ($errors->has('plate_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('plate_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
                            {!!Form::label('note', 'Note:', ['class' => 'col-md-4 control-label'])!!}

                            <div class="col-md-6">
                                {!!Form::text('note',null, ['class'=>'form-control'])!!}

                                @if ($errors->has('note'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

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


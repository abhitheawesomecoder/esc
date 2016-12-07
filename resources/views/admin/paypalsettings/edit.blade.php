@extends('admin.layouts.master')

@section('content')

<div class="row">
    <div class="col-sm-10 col-sm-offset-2">
        <h1>{{ trans('quickadmin::templates.templates-view_edit-edit') }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
                </ul>
        	</div>
        @endif
    </div>
</div>

{!! Form::model($paypalsettings, array('class' => 'form-horizontal', 'id' => 'form-with-validation', 'method' => 'PATCH', 'route' => array(config('quickadmin.route').'.paypalsettings.update', $paypalsettings->id))) !!}

<div class="form-group">
    {!! Form::label('paypal_mode', 'Paypal Mode*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('paypal_mode', old('paypal_mode',$paypalsettings->paypal_mode), array('class'=>'form-control')) !!}
        
    </div>
</div><div class="form-group">
    {!! Form::label('paypal_api_username', 'Paypal Api Username*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('paypal_api_username', old('paypal_api_username',$paypalsettings->paypal_api_username), array('class'=>'form-control')) !!}
        
    </div>
</div><div class="form-group">
    {!! Form::label('paypal_api_password', 'Paypal Api Password*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('paypal_api_password', old('paypal_api_password',$paypalsettings->paypal_api_password), array('class'=>'form-control')) !!}
        
    </div>
</div><div class="form-group">
    {!! Form::label('paypal_api_signature', 'Paypal Api Signature*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('paypal_api_signature', old('paypal_api_signature',$paypalsettings->paypal_api_signature), array('class'=>'form-control')) !!}
        
    </div>
</div><div class="form-group">
    {!! Form::label('paypal_app_id', 'Paypal App Id*', array('class'=>'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('paypal_app_id', old('paypal_app_id',$paypalsettings->paypal_app_id), array('class'=>'form-control')) !!}
        
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
      {!! Form::submit(trans('quickadmin::templates.templates-view_edit-update'), array('class' => 'btn btn-primary')) !!}
      {!! link_to_route(config('quickadmin.route').'.paypalsettings.index', trans('quickadmin::templates.templates-view_edit-cancel'), null, array('class' => 'btn btn-default')) !!}
    </div>
</div>

{!! Form::close() !!}

@endsection
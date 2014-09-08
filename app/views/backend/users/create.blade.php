@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>Create User
    <small>#{{$ticket->id_ticket}}</small>
</h1>
@stop

@section('content')

{{ Form::open(array('url'=>'admin/users', 'class'=>'form-horizontal', 'role' => 'form')) }}
<div class="row">
    <div class="col-md-5">
        <div class="box box-primary">
            <div class="box-header">
                {{FA::icon('info')}}
                <h2 class="box-title">General Info</h2>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label">First Name</label>
                    <div class="col-sm-8">
                        {{ Form::text('firstname', null, array('class'=>'form-control', 'placeholder'=>'First Name')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Last Name</label>
                    <div class="col-sm-8">
                        {{ Form::text('lastname', null, array('class'=>'form-control', 'placeholder'=>'Last Name')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-8">
                        {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Confirm Password</label>
                    <div class="col-sm-8">
                        {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        {{ Form::submit('Add User', array('class'=>'btn btn-primary'))}}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- ./Box General Info -->

    <div class="col-md-5">
        <div class="box box-warning">
            <div class="box-header">
                {{FA::icon('phone')}}
                <h2 class="box-title">Contact Info</h2>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-8">
                        {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Mobile Phone</label>
                    <div class="col-sm-8">
                        {{ Form::text('mobile_phone', null, array('class'=>'form-control', 'placeholder'=>'Mobile Phone')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">2 Mobile</label>
                    <div class="col-sm-8">
                        {{ Form::text('alt_mobile', null, array('class'=>'form-control', 'placeholder'=>'Mobile Phone')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{ Form::close() }}
@stop
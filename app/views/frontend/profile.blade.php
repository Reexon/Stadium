@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')
<div class="nav-tabs-custom">
    <!-- Tabs within a box -->
    <ul class="nav nav-tabs">
        <li class="pull-left header">{{FA::icon('info')}} My Profile</li>
        <li class="active"><a href="#general-info" data-toggle="tab">General Info</a></li>
        <li class=""><a href="#shipping-info" data-toggle="tab">Shipping Address</a></li>

    </ul>
    <div class="tab-content">
        <!-- Morris chart - Sales -->

        <div class="tab-pane active" id="general-info" style="position: relative;;">

            <div class="row">
                {{Form::model($userInfo,['url' => 'user/profile/update', 'role' => 'form'])}}
                <div class="col-md-4">
                    <div class="box box-primary">

                        <div class="box-header">
                            <h3 class="box-title">Personal Information</h3>
                        </div>

                        <div class="box-body">

                            <div class="form-group">
                                <label class="control-label">First Name</label>
                                    {{ Form::text('firstname', Input::old('firstname'), array('class'=>'form-control', 'placeholder'=>'First Name')) }}
                            </div>
                            <div class="form-group">
                                <label class="control-label">Last Name</label>
                                    {{ Form::text('lastname', Input::old('lastname'), array('class'=>'form-control', 'placeholder'=>'Last Name')) }}
                            </div>
                            <div class="form-group">
                                <label class="control-label">Birth Date:</label>
                                    {{ Form::email('email', Input::old('email'), array('class'=>'form-control', 'placeholder'=>'email')) }}
                            </div>
                        </div>
                        <div class="box-footer">
                                    {{ Form::button(FA::icon('refresh').'  Save', ['class'=>'btn btn-block btn-primary','type' => 'submit'])}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-warning">

                        <div class="box-header">
                            <h3 class="box-title">Address Info</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label">Address</label>
                                    {{ Form::text('address', Input::old('address'), array('class'=>'form-control', 'placeholder'=>'Address')) }}
                            </div>
                            <div class="form-group">
                                <label class="control-label">City</label>
                                    {{ Form::text('city', Input::old('city'), array('class'=>'form-control', 'placeholder'=>'City')) }}
                            </div>
                            <div class="form-group">
                                  <label class="control-label">CAP</label>
                                    {{ Form::text('cap', Input::old('cap'), array('class'=>'form-control', 'placeholder'=>'cap')) }}
                            </div>
                        </div>
                        <div class="box-footer">
                            {{ Form::button(FA::icon('refresh').'  Save', ['class'=>'btn btn-block btn-warning','type' => 'submit'])}}
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-success">

                        <div class="box-header">
                            <h3 class="box-title">Contact Information</h3>
                        </div>

                        <div class="box-body">

                            <div class="form-group">
                                <label class="control-label">Mobile Phone</label>
                                {{ Form::text('mobile', Input::old('mobile'), array('class'=>'form-control', 'placeholder'=>'Mobile Phone')) }}
                            </div>
                            <div class="form-group">
                                <label class="control-label">Alternative Phone</label>
                                {{ Form::text('alt_mobile', Input::old('alt_mobile'), array('class'=>'form-control', 'placeholder'=>'Alternative Mobile Number')) }}
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                {{ Form::email('email', Input::old('email'), array('class'=>'form-control', 'placeholder'=>'email')) }}
                            </div>
                        </div>
                        <div class="box-footer">
                            {{ Form::button(FA::icon('refresh').'  Save', ['class'=>'btn btn-block btn-success','type' => 'submit'])}}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>

        </div>

        <div class="tab-pane" id="shipping-info" style="position: relative; height: 300px;">
            {{Form::model($userInfo,['url' => 'user/profile/update','class'=>'form-horizontal', 'role' => 'form'])}}
            <div class="form-group">
                <label class="col-sm-2 control-label">Address</label>
                <div class="col-sm-3">
                    {{ Form::text('address', Input::old('address'), array('class'=>'form-control', 'placeholder'=>'Address')) }}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">City</label>
                <div class="col-sm-3">
                    {{ Form::text('city', Input::old('city'), array('class'=>'form-control', 'placeholder'=>'City')) }}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">CAP</label>
                <div class="col-sm-3">
                    {{ Form::text('cap', Input::old('cap'), array('class'=>'form-control', 'placeholder'=>'cap')) }}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    {{ Form::button(FA::icon('refresh').'  Save', ['class'=>'btn btn-block btn-success','type' => 'submit'])}}
                </div>
            </div>
            {{Form::close()}}
        </div>

    </div>
</div>
@stop
@extends('......layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>{{FA::icon('info')}} Edit My Profile
    <small>{{$userInfo->firstname. " ".$userInfo->lastname}}</small>
</h1>
@stop

@section('content')

{{Form::model($userInfo,['url' => 'user/profile/update', 'class'=>'form-horizontal','role' => 'form'])}}

<div class="row">

    <div class="col-md-4">
        <div class="box box-primary">

            <div class="box-header">
                <h3 class="box-title">Personal Information</h3>
            </div>

            <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label">First Name</label>
                    <div class="col-sm-8">
                        {{ Form::text('firstname', Input::old('firstname'), array('class'=>'form-control', 'placeholder'=>'First Name')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Last Name</label>
                    <div class="col-sm-8">
                        {{ Form::text('lastname', Input::old('lastname'), array('class'=>'form-control', 'placeholder'=>'Last Name')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Birth Date:</label>
                    <!--TODO: Insert Date Picker -->
                    <div class="col-sm-8">
                        <!--TODO: Cambiare il formato di visualizzazione default in d.m.Y-->
                        {{ Form::text('birth_date', Input::old('birth_date'), array('class'=>'form-control', 'placeholder'=>'Birth Date')) }}
                    </div>
                </div>
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
                    <label class="col-sm-4 control-label">Address</label>
                    <div class="col-sm-8">
                        {{ Form::text('address', Input::old('address'), array('class'=>'form-control', 'placeholder'=>'Address')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">City</label>
                    <div class="col-sm-8">
                        {{ Form::text('city', Input::old('city'), array('class'=>'form-control', 'placeholder'=>'City')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">CAP</label>
                    <div class="col-sm-8">
                        {{ Form::text('cap', Input::old('cap'), array('class'=>'form-control', 'placeholder'=>'cap')) }}
                    </div>
                </div>
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
                    <label class="col-sm-4 control-label">Mobile Phone</label>
                    <div class="col-sm-8">
                        {{ Form::text('mobile', Input::old('mobile'), array('class'=>'form-control', 'placeholder'=>'Mobile Phone')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Alt. Phone</label>
                    <div class="col-sm-8">
                        {{ Form::text('alt_mobile', Input::old('alt_mobile'), array('class'=>'form-control', 'placeholder'=>'Alternative Mobile Number')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-8">
                        {{ Form::email('email', Input::old('email'), array('class'=>'form-control', 'placeholder'=>'email')) }}
                    </div>
                </div>
            </div><!-- ./box-body -->
        </div><!-- ./box-success -->
    </div><!-- ./col-md-4 -->
    <div class="col-md-4">
        {{Form::button(FA::icon('refresh').' Save',['class' => 'form-control btn btn-success','type' => 'submit'])}}
    </div>
</div><!-- ./div Row -->
{{ Form::close() }}
@stop
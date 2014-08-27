@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

<h1>Edit {{ $user->firstname }} {{ $user->lastname}}</h1>



{{ Form::model($user, array('route' => array('users.update', $user->id_user), 'method' => 'PUT','class'=>'form-horizontal', 'role' => 'form')) }}

<div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>
    <div class="col-sm-10">
        {{ Form::text('firstname', Input::old('firstname'), array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Last Name</label>
    <div class="col-sm-10">
        {{ Form::text('lastname', Input::old('lastname'), array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
        {{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ Form::submit('Edit User!', array('class' => 'btn btn-primary')) }}
    </div>
</div>
{{ Form::close() }}

@stop

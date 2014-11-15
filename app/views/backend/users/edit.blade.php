@extends('layouts.backend.master')

@section('title')
Edit {{ $user->firstname }} {{ $user->lastname}}
    <small>#{{$user->id_user}}</small>
@stop

@section('content')

{{ Form::model($user, array('route' => array('admin.users.update', $user->id_user), 'method' => 'PUT','class'=>'form-horizontal', 'role' => 'form')) }}

<div class="form-group">
    {{ Form::label('firstname','First Name',['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('firstname', Input::old('firstname'), array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('lastname','Last Name',['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('lastname', Input::old('lastname'), array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('email','Email',['class' => 'col-sm-2 control-label']) }}
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

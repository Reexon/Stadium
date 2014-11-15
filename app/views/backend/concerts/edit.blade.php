@extends('layouts.backend.master')

@section('title')
Edit Concert {{ $concert->artist->name }}  {{ $concert->stadium }} - ({{$concert->date->format('d-m-Y')}})
    <small>#{{$concert->id_event}}</small>
@stop

@section('content')

{{ Form::model($concert, array('route' => array('admin.concerts.update', $concert->id_event), 'method' => 'PUT','class'=>'form-horizontal', 'role' => 'form')) }}

<div class="form-group">
    {{ Form::label('artist','Artist',['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::select('home_id',$artists,Input::old('home_id'),['class' => 'form-control']) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('stadium','Location',['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('stadium', Input::old('stadium'), array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('category_id','Category',['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::select('category_id',$categories, Input::old('category_id'), array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('date','Date',['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Bootstrap::date('date', '', $concert->date->format('d-m-Y'), $errors, ['class' => 'form-control datepicker'], ['format' => 'DD-MM-YYYY'])}}
    </div>
</div>
<div class="form-group">
    {{ Form::label('send_notifications','Send Notifications',['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{Form::checkbox('send_notifications','yes',false)}}  Avvisa gli utenti della modifica
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ Form::button(FA::icon('check').' Edit Concert!', array('class' => 'btn btn-success','type' => 'submit')) }}
    </div>
</div>
{{ Form::close() }}

@stop

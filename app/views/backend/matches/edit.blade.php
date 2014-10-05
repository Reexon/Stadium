@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>Edit {{ $match->homeTeam->name }} vs {{ $match->guestTeam->name }} - ({{$match->date->format('d-m-Y')}})
    <small>#{{$match->id_event}}</small>
</h1>
@stop

@section('content')

    {{ Form::model($match, array('route' => array('admin.matches.update', $match->id_event), 'method' => 'PUT','class'=>'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        {{ Form::label('home_team','Home Team',['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::select('home_id',$teams,Input::old('home_id'),['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('guest_team','Guest Team',['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::select('guest_id',$teams,Input::old('guest_id'),['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('stadium','Stadium',['class' => 'col-sm-2 control-label']) }}
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
        {{ Form::label('subcategory_id','Sub Category',['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::select('subcategory_id',$subcategories, Input::old('subcategory_id'), array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('date','Date',['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Bootstrap::date('date', '', $match->date->format('d-m-Y'), $errors, ['class' => 'form-control datepicker'], ['format' => 'DD-MM-YYYY'])}}
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
            {{ Form::button(FA::icon('check').' Edit Match!', array('class' => 'btn btn-success','type' => 'submit')) }}
        </div>
    </div>
    {{ Form::close() }}

    @stop

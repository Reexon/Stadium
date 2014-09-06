@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

    <h1>Edit {{ $match->homeTeam->name }} vs {{ $match->guestTeam->name }}</h1>

    {{ Form::model($match, array('route' => array('admin.matches.update', $match->id_match), 'method' => 'PUT','class'=>'form-horizontal', 'role' => 'form')) }}

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
        {{ Form::label('date','Date',['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Bootstrap::date('date', '', $match->date->format('d-m-Y'), $errors, ['class' => 'form-control datepicker'], ['format' => 'DD-MM-YYYY'])}}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Edit Match!', array('class' => 'btn btn-primary')) }}
        </div>
    </div>
    {{ Form::close() }}

    @stop

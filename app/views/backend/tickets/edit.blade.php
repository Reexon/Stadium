@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>{{ $ticket->match->homeTeam->name}} vs {{ $ticket->match->guestTeam->name }} ({{ $ticket->label }}) - {{ $ticket->match->date->format('d.m.Y') }}
    <small>#{{$ticket->id_ticket}}</small>
</h1>
@stop

@section('content')

{{ Form::model($ticket, array('route' => array('admin.tickets.update', $ticket->id_ticket), 'method' => 'PUT','class'=>'form-horizontal', 'role' => 'form')) }}

<div class="form-group">
    {{ Form::label('label','Ticket Type',['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('label', Input::old('label'), array('class' => 'form-control')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('price','Price',['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('price', Input::old('price'), array('class' => 'form-control')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('quantity','Quantity',['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('quantity', Input::old('quantity'), array('class' => 'form-control')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('match_id','Match',['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::select('match_id', $matches,$ticket->match->id_match ) }}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {{ Form::submit('Edit Ticket!', array('class' => 'btn btn-primary')) }}
    </div>
</div>
{{ Form::close() }}

@stop

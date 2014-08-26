@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

    <h1>Edit {{ $match->home_team }} vs {{ $match->guest_team }}</h1>

    <!-- if there are creation errors, they will show here -->
    {{ HTML::ul($errors->all()) }}

    {{ Form::model($match, array('route' => array('matches.update', $match->id_match), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('home_team', 'Home Team') }}
        {{ Form::text('home_team', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('guest_team', 'Guest Team') }}
        {{ Form::text('guest_team', null, array('class' => 'form-control')) }}
    </div>

    <!--
    <div class="form-group">
        {{ Form::label('nerd_level', 'Nerd Level') }}
        {{ Form::select('nerd_level', array('0' => 'Select a Level', '1' => 'Sees Sunlight', '2' => 'Foosball Fanatic', '3' => 'Basement Dweller'), null, array('class' => 'form-control')) }}
    </div>
    -->

    {{ Form::submit('Edit Match!', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

    @stop
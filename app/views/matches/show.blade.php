@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

    <h1>Showing {{ $match->home_team }} vs {{ $match->guest_team }}</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Date:</strong> {{ $match->date->format('m-d-Y') }}<br>
            <strong>Ticket:</strong>
        </p>
    </div>

@stop
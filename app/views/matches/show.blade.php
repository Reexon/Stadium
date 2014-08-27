@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

    <h1>Showing {{ $match->home_team }} vs {{ $match->guest_team }}</h1>

    <div class="jumbotron text-left">
        <p>
            <strong>Date:</strong> {{ $match->date->format('m-d-Y') }}<br>
            <strong>Stadium:</strong> {{ $match->stadium }} <br>
            <strong>City:</strong> {{ $match->city }} <br>
        </p>
    </div>
    <div style="width:30%;">
        @if(count($match->tickets)>0)
            <table class="table table-bordered">
                <thead>
                <tr class="success">
                    <th colspan="3" style="text-align:center;">Tickets</th>
                </tr>
                <tr>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                @foreach($match->tickets as $ticket)
                <tr>
                    <!-- TODO: Link to ticket -->
                    <td>{{ $ticket->label }}</td>
                    <td>{{ $ticket->quantity}}</td>
                    <td>{{ $ticket->price }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <a class="btn btn-primary btn-lg btn-block btn-success" href="{{ URL::to('tickets/create/' . $match->id_match) }}">{{FA::icon('plus')}} Add Tickets</a>

        @else
            <h2>No Tickets Found !</h2>
            <a class="btn btn-primary btn-lg btn-block btn-success" href="{{ URL::to('tickets/create/' . $match->id_match) }}">Create Tickets</a>
        @endif
    </div>
@stop
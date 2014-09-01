@extends('layouts.master')

@section('head')
@parent

@stop

@section('navigation')
@parent
@stop

@section('content')

<h1>All Tickets Selled</h1>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>Ticket Type</td>
        <td>Quantity</td>
        <td>Total</td>
    </tr>
    </thead>
    <tbody>
    @foreach($tickets as $ticket)
    <tr>
        <td>{{ $ticket->label }}</td>

        <td>{{ $ticket->quantity }}</td>

        <td>{{ $ticket->total_price }}</td>

    </tr>
    @endforeach
    </tbody>
</table>
@stop
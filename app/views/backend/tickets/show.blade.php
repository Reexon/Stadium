@extends('layouts.master')

@section('head')
@parent

@stop

@section('navigation')
@parent
@stop

@section('content')

<h1>All Ticket Selled For : {{$ticket->match->homeTeam->name}} vs {{$ticket->match->guestTeam->name}} ({{ $ticket->match->date->format('d-m-Y')}})</h1>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Payment ID</th>
        <th>Buyer</th>
        <th>Quantity</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($ticket->orders as $order)
    <tr>
        <td><a href="{{URL::to('admin/payments/'.$order->payment->id_payment)}}">#{{ $order->payment->id_payment }}</a></td>
        <td><a href="{{URL::to('admin/users/'.$order->payment->user->id_user)}}">{{ $order->payment->user->firstname }}</a></td>
        <td>{{ $order->quantity }}</td>
        <td>{{ $order->quantity * $ticket->price}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@stop
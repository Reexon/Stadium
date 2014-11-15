@extends('layouts.backend.master')

@section('title')
All Ticket Selled For : {{$ticket->match->homeTeam->name}} vs {{$ticket->match->guestTeam->name}} ({{ $ticket->match->date->format('d-m-Y')}})
<small>#{{$ticket->id_ticket}}</small>

@stop

@section('content')


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
        <td><a href="{{URL::to('admin/users/'.$order->payment->user->id_user)}}">{{ $order->payment->user->firstname }} {{$order->payment->user->lastname}}</a></td>
        <td>{{ $order->quantity }}</td>
        <td>{{ number_format($order->quantity * $ticket->price,2,',','.')}} €</td>
    </tr>
    @endforeach
    </tbody>
</table>
@stop
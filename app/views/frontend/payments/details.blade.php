@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>Payment Detail
    <small>#{{ $payment->id_payment }}</small>
</h1>
@stop

@section('content')

@if(is_object($payment))
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">
        <b>Date Purchase:</b>{{$payment->pay_date->format('d.m.Y')}}
        <span class="badge pull-right">Purchase Code: #{{$payment->id_payment}}</span>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Match</th>
            <th>Ticket</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        </thead>

        <tbody>

        @foreach($payment->orders as $order)
        <tr>
            <td>{{$order->id_order}}</td>
            <td>{{$order->ticket->match->homeTeam->name}} - {{$order->ticket->match->guestTeam->name}} ({{$order->ticket->match->date->format('d.m.Y')}})</td>
            <td>{{$order->ticket->label}}</td>
            <td>{{$order->quantity}}</td>
            <td>{{number_format($order->quantity * $order->ticket->price,2,',','.')}}</td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4"></td>
            <td><b>{{number_format($payment->total,2,',','.')}} €</b></td>
        </tr>
        </tfoot>
    </table>
</div>
</div>
@else
<h2>you've no payment !</h2>
@endif

@stop
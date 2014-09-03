@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

@if(is_object($userInfo->payments()))
    @foreach($userInfo->payments as $payment)
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
                    <td>#</td>
                    <td>{{$order->ticket->match->home_team}} - {{$order->ticket->match->guest_team}} ({{$order->ticket->match->date->format('d.m.Y')}})</td>
                    <td>{{$order->ticket->label}}</td>
                    <td>{{$order->quantity}}</td>
                    <td>{{$order->quantity * $order->ticket->price}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td><b>{{$payment->total}} €</b></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
    @endforeach
@else
    <h2>you've no payment !</h2>
@endif

@stop
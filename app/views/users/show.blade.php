@extends('layouts.master')

@section('head')
@parent
<style>
    .form-control { width: 100%; }
</style>
@stop


@section('navigation')
@parent
@stop


@section('content')

<h1>{{ $user->firstname }} {{ $user->lastname }} <a class="btn btn-small btn-info" href="{{ URL::to('users/'.$user->id_user .'/edit')}}">{{FA::lg('pencil')}}</a> </h1>

<div class="jumbotron ">
    <p class="text-left">
        <strong>Register Date:</strong> {{ $user->created_at->format('m-d-Y H:i:s') }}<br>
        <strong>Address:</strong>
        <address>
            {{$user->city}}<br/>
            {{$user->address}}<br/>
            {{$user->cap}}<br/>
            {{$user->cell}}
        </address>
    </p>
    <p class="text-right">
        <a class="btn btn-primary btn-lg btn-block btn-success" href="{{URL::to('mails/create')}}">{{FA::icon('envelope-o')}} Contact User</a>
    </p>
</div>

<div style="width:30%;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="3" style="text-align:center;">Purchased Tickets</th>
            </tr>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
        @foreach($user->payments as $payment)
            @foreach($payment->orders as $order)
            <tr>
                <td>{{ $order->id_order }}</td>
                <td>{{ $order->ticket->label }}</td>
                <td>{{ $order->quantity }}</td>
            </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</div>

<div class="btn-group btn-group-justified">
    <a class="btn btn-primary btn-lg btn-block btn-success" href="{{ URL::to('tickets/create/' . $user->id_match) }}">{{FA::icon('plus')}} Add Tickets</a>
    <a class="btn btn-primary btn-lg btn-block btn-success" href="{{ URL::to('tickets/create/' . $user->id_match) }}">{{FA::icon('plus')}} Add Tickets</a>
    <a class="btn btn-primary btn-lg btn-block btn-success" href="{{ URL::to('tickets/create/' . $user->id_match) }}">{{FA::icon('plus')}} Add Tickets</a>
</div>
@stop
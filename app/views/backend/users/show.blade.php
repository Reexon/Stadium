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


@section('header-title')
<h1>{{ $user->firstname }} {{ $user->lastname }} <a class="btn btn-small btn-info" href="{{ URL::to('admin/users/'.$user->id_user .'/edit')}}">{{FA::lg('pencil')}}</a>
    <small></small>
</h1>
@stop
@section('content')


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
        <strong>Email:</strong> {{ $user->email }}<br>
    </p>
    <p class="text-right">
        <a class="btn btn-primary btn-lg btn-block btn-success" href="{{URL::to('admin/mails/create')}}">{{FA::icon('envelope-o')}} Contact User</a>
    </p>
</div>
<div class="row">
    <div class="col-md-4">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-green">
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
    <div class="col-md-4">
        <table class="table table-bordered">
            <thead>
            <tr class="bg-yellow">
                <th colspan="3" style="text-align:center;">Payment</th>
            </tr>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($user->payments as $payment)
            <tr>
                <td><a href="{{URL::to('admin/payments/'.$payment->id_payment)}}">#{{ $payment->id_payment }}</a></td>
                <td>{{ $payment->pay_date->format('d.m.Y')}}</td>
                <td>{{ $payment->total }}</td>
            </tr>

            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('header-title')
<h1>All Your Payments
    <small></small>
</h1>
@stop

@section('content')

@if(is_object($userInfo->payments()))
    @foreach($userInfo->payments as $payment)
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$payment->id_payment}}</td>
                    <td>{{$payment->pay_date->format('d.m.Y')}}</td>
                    <td>{{number_format($payment->total,2,',','.')}} €</td>
                    <td><a class="btn btn-small btn-success" href="{{ URL::to('user/payments/' . $payment->id_payment) }}">{{ FA::icon('eye')}}</a></td>
                </tr>
            </tbody>
        </table>
    @endforeach
@else
    <h2>you've no payment !</h2>
@endif

@stop
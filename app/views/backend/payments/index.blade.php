@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop

@section('header-title')
<h1>
    All Payments <a href="{{URL::to('admin/payments/create')}}" class="btn btn-sm btn-primary">{{FA::icon('plus')}}</a>
    <small>Overview</small>
</h1>
@stop
@section('content')

<table class="table table-striped">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($successPayments as $payment)

            <tr>
                <td>{{$payment->pay_date}}</td>
                <td>{{$payment->status}}</td>
                <td>{{$payment->user->firstname}} {{$payment->user->lastname}}</td>
            </tr>

    @endforeach
    </tbody>
</table>
@stop
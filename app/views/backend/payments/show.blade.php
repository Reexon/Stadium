@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop


@section('header-title')
<h1>Payments Details
    <small>#{{$payment->id_payment}}</small>
</h1>
@stop

    @section('content')

<div class="box box-info">
    <div class="box-header">
        <div class="box-title"><h3>Buyer Information</h3></div>
    </div>
    <div class="box-body">
        <?php $user = $payment->user; ?>
        <!-- TODO: Sistemare visualizzazione delle informazioni buyer -->
        Name: {{$user->firstname}} {{$user->lastname}}<br>
        Payment Date: {{$payment->pay_date->format('d.m.Y')}}<br>
        Address: {{$user->address}},{{$user->city}},{{$user->cap}}<br>
        Mobile: {{$user->mobile}}<br>
        Mail: {{$user->email}}
    </div>
    <div class="box-footer bg-aqua">

    </div>
</div>
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Ticket</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach($payment->orders as $order)
            <tr>
                <td>{{ $order->id_order }}</td>
                <td>{{ $order->ticket->label }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->quantity * $order->ticket->price }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3"></th>
                <th>{{ number_format($payment->total,2,',','.')}} €</th>
            </tr>
        </tfoot>
    </table>
    @stop
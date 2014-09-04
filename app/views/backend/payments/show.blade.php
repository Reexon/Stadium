@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop


    @section('content')



<div class="box box-info">
    <div class="box-header">
        <div class="box-title"><h3>Buyer Information</h3></div>
    </div>
    <div class="box-body">
        <?php $user = $payment->user; ?>
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
                <th>{{$payment->total}}</th>
            </tr>
        </tfoot>
    </table>
    @stop
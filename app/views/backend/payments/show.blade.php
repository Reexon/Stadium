@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop


    @section('content')


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
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
            <span class="badge pull-right">Track Code: #{{$payment->trackid}}</span>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Event</th>
                <th>Ticket</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            </thead>

            <tbody>

            @foreach($payment->orders as $order)
            <tr>
                <td>{{$order->id_order}}</td>
                <?php $category = $order->ticket->event->category; ?>
                <td>{{$category->name}}</td>
                @if(in_array($category->id_category,Backend\Model\Match::$category))
                    <td>{{$order->ticket->match->homeTeam->name}} - {{$order->ticket->match->guestTeam->name}} ({{$order->ticket->match->date->format('d.m.Y')}})</td>
                @elseif(in_array($category->id_category,Backend\Model\Concert::$category))
                    <td>{{$order->ticket->concert->artist->name}} - ({{$order->ticket->concert->date->format('d.m.Y')}})</td>
                @endif
                <td>{{$order->ticket->label}}</td>
                <td>{{$order->quantity}}</td>
                <td>{{number_format($order->quantity * $order->ticket->price,2,',','.')}}</td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5"></td>
                <td><b>{{number_format($payment->total,2,',','.')}} €</b></td>
            </tr>
            </tfoot>
        </table>
    </div>
    @else
    <h2>you've no payment !</h2>
    @endif
@stop
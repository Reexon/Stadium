@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>Detail {{ $concert->artist->name }} - ({{$concert->date->format('d-m-Y')}})
    <small>#{{$concert->id_event}}</small>
</h1>
@stop

@section('content')

<div class="jumbotron text-left">
    <p>
        <strong>Date:</strong> {{ $concert->date->format('m-d-Y') }}<br>
        <strong>Stadium:</strong> {{ $concert->stadium }} <br>
        <strong>City:</strong> {{ $concert->city }} <br>
    </p>
</div>
<!-- Visualizzazione Di tutti i ticket -->
<div class="col-md-4">
    @if(count($concert->tickets)>0)
    <table class="table table-bordered">
        <thead>
        <tr class="bg-green">
            <th colspan="3" style="text-align:center;">Tickets</th>
        </tr>
        <tr>
            <th>Type</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
        @foreach($concert->tickets as $ticket)
        <tr>
            <!-- TODO: Link to ticket -->
            <td>{{ $ticket->label }}</td>
            <td>{{ $ticket->quantity}}</td>
            <td>{{ $ticket->price }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <h2>No Tickets !</h2>
    @endif
    <a class="btn btn-primary btn-lg btn-block btn-success" href="{{ URL::to('admin/tickets/create/'.$concert->category_id.'/' . $concert->id_event) }}">{{FA::icon('ticket')}} Create Tickets</a>
</div>

<!-- Visualizzazione di tutti gli acquisti -->
<div class="col-md-4">

    <!-- questo controllo serve per gestire i casi in cui non siano presenti pagamenti -->
    @if(is_object($concert->tickets->first()) && count($concert->tickets->first()->orders)> 0)
    <table class="table table-bordered">
        <thead>
        <tr class="bg-yellow">
            <th colspan="4" style="text-align:center;">Last Purchase</th>
        </tr>
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($concert->tickets as $ticket)
        @foreach($ticket->orders as $order)
        <tr>
            <td><a href="{{URL::to('admin/users/'.$order->payment->user->id_user)}}">{{ $order->payment->user->firstname }} {{ $order->payment->user->lastname }}</a></td>
            <td>{{ $order->quantity }}</td>
            <td>{{ $order->payment->total}}</td>
            <td>{{ $order->payment->pay_date->format('d-m-Y') }}</td>
        </tr>
        @endforeach
        @endforeach
        </tbody>
    </table>
    @else
    <h2>No Purchases !</h2>
    @endif
    <div class="clearfix">
        <a class="btn btn-primary btn-lg btn-block btn-warning" href="{{ URL::to('admin/payments/create') }}">{{FA::icon('euro')}} Add Payment</a>
    </div>
</div>

<!-- Visualizzazione di tutti i subscriber -->
<div class="col-md-4">
    @if(count($concert->subscribers)>0)
    <table class="table table-bordered">
        <thead>
        <tr class="bg-red">
            <th colspan="3" style="text-align:center;">Subscribers</th>
        </tr>
        <tr>
            <th>Email</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($concert->subscribers as $subscriber)
        <tr>
            <td>{{ $subscriber->email }}</td>
            <td>{{ $subscriber->created_at->format('d.m.Y')}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <h2>No Subscribers !</h2>
    @endif
    <div class="clearfix">
        <!--TODO:Link to page for adding new sub-->
        <a class="btn btn-primary btn-lg btn-block btn-danger" href="">{{FA::icon('envelope')}} Add Subscribers</a>
    </div>
</div>
@stop
@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

    <h1>Showing {{ $match->homeTeam->name }} vs {{ $match->guestTeam->name }}</h1>

    <div class="jumbotron text-left">
        <p>
            <strong>Date:</strong> {{ $match->date->format('m-d-Y') }}<br>
            <strong>Stadium:</strong> {{ $match->stadium }} <br>
            <strong>City:</strong> {{ $match->city }} <br>
        </p>
    </div>
<!-- Visualizzazione Di tutti i ticket -->
<div class="col-md-3">
        @if(count($match->tickets)>0)
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
                @foreach($match->tickets as $ticket)
                <tr>
                    <!-- TODO: Link to ticket -->
                    <td>{{ $ticket->label }}</td>
                    <td>{{ $ticket->quantity}}</td>
                    <td>{{ $ticket->price }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        <div class="clearfix">
            <a class="btn btn-primary btn-lg btn-block btn-success" href="{{ URL::to('admin/tickets/create/' . $match->id_match) }}">{{FA::icon('plus')}} Add Tickets</a>
        </div>
        @else
            <h2>No Tickets !</h2>
            <a class="btn btn-primary btn-lg btn-block btn-success" href="{{ URL::to('admin/tickets/create/' . $match->id_match) }}">Create Tickets</a>
        @endif
</div>

<!-- Visualizzazione di tutti gli acquisti -->
<div class="col-md-4">

    <!-- questo controllo serve per gestire i casi in cui non siano presenti pagamenti -->
    @if(is_object($match->tickets->first()) && count($match->tickets->first()->orders)> 0)
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
        @foreach($match->tickets as $ticket)
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
        <a class="btn btn-primary btn-lg btn-block btn-warning" href="{{ URL::to('admin/payments/create') }}">{{FA::icon('plus')}} Add Payment</a>
    </div>
    </div>

<!-- Visualizzazione di tutti i subscriber -->
<div class="col-md-4">
    @if(count($match->subscribers)>0)
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
        @foreach($match->subscribers as $subscriber)
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
        <a class="btn btn-primary btn-lg btn-block btn-danger" href="">{{FA::icon('plus')}} Add Subscribers</a>
    </div>
</div>
@stop
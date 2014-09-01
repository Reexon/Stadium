@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

    <h1>Showing {{ $match->home_team }} vs {{ $match->guest_team }}</h1>

    <div class="jumbotron text-left">
        <p>
            <strong>Date:</strong> {{ $match->date->format('m-d-Y') }}<br>
            <strong>Stadium:</strong> {{ $match->stadium }} <br>
            <strong>City:</strong> {{ $match->city }} <br>
        </p>
    </div>
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
            <h2>No Tickets Found !</h2>
            <a class="btn btn-primary btn-lg btn-block btn-success" href="{{ URL::to('admin/tickets/create/' . $match->id_match) }}">Create Tickets</a>
        @endif
</div>
<div class="col-md-4">
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
    <div class="clearfix">
    <a class="btn btn-primary btn-lg btn-block btn-warning" href="{{ URL::to('admin/payments/create') }}">{{FA::icon('plus')}} Add Payment</a>
    </div>
    </div>
@stop
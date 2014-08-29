@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop

@section('content')

<h1>All Payments</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Ticket</th>
            <th>Match</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($payments as $payment)
    <tr>
        <td rowspan="{{ count($payment->orders)+1 }}" style="vertical-align:middle;">{{ $payment->id_payment }}</td>
        <td rowspan="{{ count($payment->orders)+1 }}" style="vertical-align:middle;">{{ $payment->user->firstname }} {{ $payment->user->lastname }}</td>
        <?php $firstLoop = true;?>
        @foreach($payment->orders as $order)
        <tr>
            <td>{{ $order->ticket->label }}</td>
            <td>{{ $order->ticket->match->home_team }} vs {{ $order->ticket->match->guest_team }}</td>
            <td style="vertical-align:middle;">{{ $order->quantity }}</td>
            @if($firstLoop)
                <td rowspan="{{ count($payment->orders) }}" style="vertical-align:middle;">{{ $payment->pay_date->format('d-m-Y') }}</td>
                <td rowspan="{{ count($payment->orders) }}" style="vertical-align:middle;">{{ number_format($payment->total, 2, ',', '.') }}</td>
                <td rowspan="{{ count($payment->orders) }}" style="vertical-align:middle;">

                    <a class="btn btn-small btn-success" href="{{ URL::to('payments/' . $payment->id_payment) }}">{{ FA::icon('eye'); }}</a>

                    <a class="btn btn-small btn-info" href="{{ URL::to('payments/' . $payment->id_payment . '/edit') }}">{{ FA::icon('pencil'); }}</a>

                    <!-- TODO: Confirmation Before Delete -->
                    {{ Form::open(array('url' => 'payments/' . $payment->id_payment,'style' =>'display:inline-block','method'=>'DELETE')) }}
                    {{ Form::button(FA::icon('trash-o'), array('type' => 'submit', 'class' => 'btn btn-small btn-danger'))}}
                    {{ Form::close() }}
                </td></tr>
            @else
                </tr>
            @endif
    <?php $firstLoop = false;?>
        @endforeach


    </tr>
    @endforeach
    </tbody>
</table>

<?php //$payments->links(); ?>
@stop
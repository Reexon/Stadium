@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop

@section('header-title')
<h1>
    All Payments
    <small>Overview</small>
</h1>
@stop
@section('content')

<table class="table table-bordered">
    <thead>
        <tr>
            {{ Form::open(['url' => 'admin/payments/search','method' => 'GET']) }}
                <td>
                    {{ Form::text('id_payment', Input::old('id_payment'), ['class' => 'form-control','placeholder' => '# Payment']) }}
                </td>
                <td>
                    {{ Form::text('firstname', Input::old('firstname'), ['class' => 'form-control','placeholder' => 'user']) }}
                </td>
            <td>
                {{ Form::text('label', Input::old('label'), ['class' => 'form-control','placeholder' => 'Ticket Type']) }}
            </td>
            <td>
                {{ Form::text('match', Input::old('match'), ['class' => 'form-control','placeholder' => 'Match']) }}
            </td>
            <td></td>
            <td>
                {{ Form::text('data', Input::old('data'), ['class' => 'form-control','placeholder' => 'data']) }}
            </td>
            <td></td>
            <td></td>
            {{ Form::close() }}
        </tr>
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
        <td rowspan="{{ count($payment->orders)+1 }}" style="vertical-align:middle;">
            <a href="{{URL::to('admin/payments/'.$payment->id_payment)}}">{{ $payment->id_payment }}</a>
        </td>
        <td rowspan="{{ count($payment->orders)+1 }}" style="kvertical-align:middle;">
            <a href="{{URL::to('admin/users/'.$payment->user->id_user)}}">
                {{ $payment->user->firstname }} {{ $payment->user->lastname }}
            </a>
        </td>
        <?php $firstLoop = true;?>
        @foreach($payment->orders as $order)
        <tr>
            <td>{{ $order->ticket->label }}</td>
            <td>
                <a href="{{URL::to('admin/matches/'.$order->ticket->match->id_match)}}">
                    {{ $order->ticket->match->homeTeam->name }} vs {{ $order->ticket->match->guestTeam->name }}
                </a>
            </td>
            <td style="vertical-align:middle;">{{ $order->quantity }}</td>
            @if($firstLoop)
                <td rowspan="{{ count($payment->orders) }}" style="vertical-align:middle;">{{ $payment->pay_date->format('d-m-Y') }}</td>
                <td rowspan="{{ count($payment->orders) }}" style="vertical-align:middle;">{{ number_format($payment->total, 2, ',', '.') }}</td>
                <td rowspan="{{ count($payment->orders) }}" style="vertical-align:middle;">

                    <a class="btn btn-small btn-success" href="{{ URL::to('admin/payments/' . $payment->id_payment) }}">{{ FA::icon('eye'); }}</a>

                    <a class="btn btn-small btn-info" href="{{ URL::to('admin/payments/' . $payment->id_payment . '/edit') }}">{{ FA::icon('pencil'); }}</a>

                    <!-- TODO: Confirmation Before Delete -->
                    {{ Form::open(array('url' => 'admin/payments/' . $payment->id_payment,'style' =>'display:inline-block','method'=>'DELETE')) }}
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

{{ $payments->links() }}
@stop
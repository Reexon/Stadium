@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('header-title')
<h1>
    @if(count($event->tickets) > 0 )
            Event Information - {{$event->title}}
    @else
        No Tickets Available !
    @endif
    <small>#{{$event->id_event}}</small>
</h1>
@stop

@section('content')

<?php $total = 0; ?>
@foreach($event->tickets as $ticket)
    <?php $total += $ticket->quantity;?>
@endforeach

@if(count($event->tickets)==0 || $total == 0)
<div class="box box-danger">
    <div class="box-header">
        <i class="fa fa-warning"></i>
        <h3 class="box-title">Attention !</h3>
    </div>
    <div class="box-body">There aren't tickets available for this match at the moment ! <br>
        If you want to be notified when new tickets are available, please insert your eMail here
        {{Form::open(['url' => 'match/signup/'.$event->id_event],['class' =>'form-inline']) }}

        <div class="input-group">
                <span class="input-group-btn">
                    {{Form::email('email','',['placeholder' => 'Your Email','class' =>'form-control','style' => 'width:300px;'])}}
                    {{Form::button('Send',['type' => 'submit', 'class' => 'btn btn-warning'])}}
                </span>
        </div>

        {{Form::close()}}
    </div>
</div>
@endif

@if(count($event->tickets) >0 )

<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Ticket Type</th>
        <th>Price</th>
        <th>Available</th>
        <th>Select</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($event->tickets as $ticket)
    <tr>
        {{ Form::open(array('url' => 'cart/update','class' => 'form-inline')) }}
            {{ Form::hidden('ticket_id',$ticket->id_ticket) }}
        <td>{{$ticket->label }}</td>
        <td>{{$ticket->price }}</td>
        <td>{{$ticket->quantity }}</td>
        <td>
            @if($ticket->quantity == 0)
                <span class="label label-danger">Sold Out</span>
            @else
                {{ Form::selectRange('quantity', 1, $ticket->quantity) }}
            @endif
        </td>
        <td>
            @if($ticket->quantity > 0)
                {{ Form::button(FA::icon('shopping-cart'), ['class' => 'btn btn-large btn-primary','type' =>'submit'])}}
            @endif
        </td>
        {{ Form::close() }}
    </tr>
    @endforeach
    </tbody>
</table>

@endif

@stop
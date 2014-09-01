@extends('layouts.frontend')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

<table class="table ">
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
    @foreach($match->tickets as $ticket)
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
@stop
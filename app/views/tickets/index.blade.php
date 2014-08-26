@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop

@section('content')

<h1>All Tickets</h1>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>ID</td>
        <td>Type</td>
        <td>Price</td>
        <td>Match</td>
        <td>Actions</td>
    </tr>
    </thead>
    <tbody>
    @foreach($tickets as $key => $value)
    <tr>
        <td>{{ $value->id_ticket }}</td>
        <td>{{ $value->label }}</td>
        <td>{{ $value->price }}</td>
        <td>
            no match
        </td>
        <td>
            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
            <a class="btn btn-small btn-success" href="{{ URL::to('tickets/' . $value->id_ticket) }}">{{ FA::icon('eye'); }}</a>

            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
            <a class="btn btn-small btn-info" href="{{ URL::to('tickets/' . $value->id_ticket . '/edit') }}">{{ FA::icon('pencil'); }}</a>

            <!-- TODO: Confirmation Before Delete -->
            {{ Form::open(array('url' => 'tickets/' . $value->id_ticket,'style' =>'display:inline-block')) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::button(FA::icon('trash-o'), array('type' => 'submit', 'class' => 'btn btn-small btn-danger'))}}
            {{ Form::close() }}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@stop
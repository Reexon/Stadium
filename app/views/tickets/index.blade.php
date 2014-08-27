@extends('layouts.master')

@section('head')
@parent
<script>
    $(function() {
        $('a[data-toggle=popover]').popover({
            html : true,
            delay: {
                show: "500",
                hide: "100"
            }
        });
    });
</script>
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
        <td>Match</td>
        <td>Type</td>
        <td>Quantity</td>
        <td>Price</td>
        <td>Actions</td>
    </tr>
    </thead>
    <tbody>
    @foreach($tickets as $ticket)
    <tr>
        <!-- TODO: raggruppamento in base al match -->
        <td>{{ $ticket->id_ticket }}</td>

        <!-- TODO: Link ai dettagli del match -->
        <td>
            <a href="#"
               data-trigger="hover"
               data-content="<b>When:</b> {{ $ticket->match->date->format('d-m-Y') }}<br>
                             <b>Where:</b> {{ $ticket->match->stadium}}"
               data-placement="right"
               data-toggle="popover">{{ $ticket->match->home_team }} vs {{ $ticket->match->guest_team }}</a>
        </td>

        <td>{{ $ticket->label }}</td>

        <td>{{ $ticket->quantity }}</td>

        <!-- TODO: currency in base ai setting admin -->
        <td>{{ $ticket->price }}</td>


        <td>
            <!--  GET /nerds/{id} -->
            <a class="btn btn-small btn-success" href="{{ URL::to('tickets/' . $ticket->id_ticket) }}">{{ FA::icon('eye'); }}</a>

            <!-- GET /nerds/{id}/edit -->
            <a class="btn btn-small btn-info" href="{{ URL::to('tickets/' . $ticket->id_ticket . '/edit') }}">{{ FA::icon('pencil'); }}</a>

            <!-- TODO: Confirmation Before Delete -->
            {{ Form::open(array('url' => 'tickets/' . $ticket->id_ticket,'style' =>'display:inline-block')) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::button(FA::icon('trash-o'), array('type' => 'submit', 'class' => 'btn btn-small btn-danger'))}}
            {{ Form::close() }}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@stop
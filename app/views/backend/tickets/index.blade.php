@extends('layouts.backend.master')

@section('title')
All Tickets <a href="{{URL::to('admin/tickets/create')}}" class="btn btn-sm btn-primary">{{FA::icon('plus')}}</a>
    <small></small>
@stop

@section('content')

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Event</th>
        <th>Type</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($match_tickets as $ticket)
    <tr>
        <!-- TODO: raggruppamento in base al match -->
        <td>{{ $ticket->id_ticket }}</td>

        <!-- TODO: Link ai dettagli del match -->
        <td>
            <a href="{{ URL::to('admin/matches/'.$ticket->match->id_event) }}"
               data-trigger="hover"
               data-content="<b>When:</b> {{ $ticket->match->date->format('d-m-Y') }}<br>
                             <b>Where:</b> {{ $ticket->match->stadium}}"
               data-placement="right"
               data-toggle="popover">{{ $ticket->event->homeTeam->name }} vs {{ $ticket->match->guestTeam->name }}</a>
        </td>

        <td>{{ $ticket->label }}</td>

        <td>{{ $ticket->quantity }}</td>

        <!-- TODO: currency in base ai setting admin -->
        <td>{{ $ticket->price }}</td>


        <td>
            <a class="btn btn-small btn-success" href="{{ URL::to('admin/tickets/' . $ticket->id_ticket) }}">{{ FA::icon('ticket'); }}</a>

            <a class="btn btn-small btn-info" href="{{ URL::to('admin/tickets/' . $ticket->id_ticket . '/edit') }}">{{ FA::icon('pencil'); }}</a>

            <!-- TODO: Confirmation Before Delete -->
            {{ Form::open(array('url' => 'admin/tickets/' . $ticket->id_ticket,'style' =>'display:inline-block')) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::button(FA::icon('trash-o'), array('type' => 'submit', 'class' => 'btn btn-small btn-danger'))}}
            {{ Form::close() }}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

{{ $match_tickets->links()}}

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Event</th>
        <th>Type</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($concert_tickets as $ticket)
    <tr>
        <!-- TODO: raggruppamento in base al match -->
        <td>{{ $ticket->id_ticket }}</td>

        <!-- TODO: Link ai dettagli del match -->
        <td>
            <a href="{{ URL::to('admin/matches/'.$ticket->concert->id_event) }}"
               data-trigger="hover"
               data-content="<b>When:</b> {{ $ticket->concert->date->format('d-m-Y') }}<br>
                             <b>Where:</b> {{ $ticket->concert->stadium}}"
               data-placement="right"
               data-toggle="popover">{{ $ticket->concert->artist->name }}</a>
        </td>

        <td>{{ $ticket->label }}</td>

        <td>{{ $ticket->quantity }}</td>

        <!-- TODO: currency in base ai setting admin -->
        <td>{{ $ticket->price }}</td>


        <td>
            <a class="btn btn-small btn-success" href="{{ URL::to('admin/tickets/' . $ticket->id_ticket) }}">{{ FA::icon('ticket'); }}</a>

            <a class="btn btn-small btn-info" href="{{ URL::to('admin/tickets/' . $ticket->id_ticket . '/edit') }}">{{ FA::icon('pencil'); }}</a>

            <!-- TODO: Confirmation Before Delete -->
            {{ Form::open(array('url' => 'admin/tickets/' . $ticket->id_ticket,'style' =>'display:inline-block')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::button(FA::icon('trash-o'), array('type' => 'submit', 'class' => 'btn btn-small btn-danger'))}}
            {{ Form::close() }}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@stop

@section('footer-javascript')
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
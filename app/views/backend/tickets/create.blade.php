@extends('layouts.master')

@section('head')
@parent
<script>
    $(document).on('click','.datepicker',function(){
        $(this).datetimepicker({ pickTime: false, format: "DD-MM-YYYY" });
    });

    $(document).on('click','#addTicket',function(){
        var tableBody = $('table tbody');//prendo il tbody
        var ticket_type = '{{ Form::text('label[]', Input::old('label'), array('class' => 'form-control','placeholder' => 'Ticket Type')) }}';
        var ticket_price ='{{ Form::text('price[]', Input::old('price'), array('class' => 'form-control','placeholder' => 'Price')) }}';
        var ticket_quantity ='{{ Form::text('quantity[]', Input::old('quantity'), array('class' => 'form-control','placeholder' => 'Quantity')) }}';
        var selectMatch ='{{ Form::select('event_id[]', $events,null,['class' => 'form-control']) }}';
        var addTicket = '{{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addTicket'])}}';
        var deleteTicket ='{{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteTicket'])}}';

        //rimuovo il bottone (addTicket) dalla riga corrente (verrà aggiunto nella riga successiva
        $(this).remove();
        var index = $('table.table tbody tr').length+1;
        tableBody.append('<tr><td>'+index+'</td><td>'+ticket_type+'</td><td>'+ticket_price+'</td><td>'+ticket_quantity+'</td><td>'+selectMatch+'</td><td>'+addTicket+' '+deleteTicket+'</td></tr>');

    });

    $(document).on('click','#deleteTicket',function(){
        var current_tr = $(this).closest('tr');
        var last_tr = $('table.table tbody tr:last');
        var total_row = $('table.table tbody tr').length;


        //posso cancellare solo se sono presenti + di una riga
        if(total_row >1){
            /*
             se sto eliminando la riga in fondo alla tabella
             devo gestire lo spostamento dell'add e del delete button
             */
            if(current_tr.is(last_tr)){
                var addTicket = '{{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addTicket'])}}';
                var deleteTicket ='{{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteTicket'])}}';

                //prelevo ultimo td della PENULTIMA riga (devo ri-aggiungere il bottone add)
                var last_td = $('table.table tbody tr').eq(-2).find('td:last');
                last_td.html(addTicket+' '+deleteTicket);
            }
            //rimuovo la riga su cui è stato premuto il tasto cancella
            current_tr.remove();
        }

    });
</script>
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>Add New Ticket
    <small></small>
</h1>
@stop
@section('content')

{{ Form::open(array('url' => 'admin/tickets','class' => 'form-inline')) }}
    {{Form::hidden('category_id',$category_id)}}
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Match</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td>
            {{ Form::text('label[]', Input::old('label'), array('class' => 'form-control','placeholder' => 'Ticket Type')) }}
        </td>
        <td>
            {{ Form::text('price[]', Input::old('price'), array('class' => 'form-control','placeholder' => 'Price')) }}
        </td>
        <td>
            {{ Form::text('quantity[]', Input::old('quantity'), array('class' => 'form-control','placeholder' => 'Quantity')) }}
        </td>
        <td>
            {{ Form::select('event_id[]', $events,$match_id,['class' => 'form-control']) }}
        </td>
        <td>
            {{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addTicket'])}}
            {{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteTicket'])}}
        </td>
    </tr>
    </tbody>
</table>
@if(is_object($match))
    @if (count($match->subscribers) > 0)
        {{ Form::checkbox('send_notifications', 'yes')}} Send Notification to subscribers
    @endif
@endif

{{ Form::button(FA::icon('check').' Create Tickets!', ['class' => 'btn btn-success','type' => 'submit']) }}


{{ Form::close() }}

@stop
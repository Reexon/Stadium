@extends('layouts.master')

@section('head')
@parent
<script>
    var default_tr;
    $(function(){
        default_tr = $('table tbody:first').clone();
    });

    $(document).on('click','.datepicker',function(){
        $(this).datetimepicker({ pickTime: false, format: "DD-MM-YYYY" });
    });

    $(document).on('click','#addOrder',function(){
        var tableBody = $('table tbody:first');//prendo il tbody

        //rimuovo il bottone (add) dalla riga corrente (verrà aggiunto nella riga successiva)
        $(this).remove();

        tableBody.append(default_tr.html());

    });

    $(document).on('click','#deleteOrder',function(){
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
                var addTicket = '{{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addOrder'])}}';
                var deleteTicket ='{{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteOrder'])}}';

                //prelevo ultimo td della PENULTIMA riga (devo ri-aggiungere il bottone add)
                var last_td = $('table.table tbody tr').eq(-2).find('td:last');
                last_td.html(addTicket+' '+deleteTicket);
            }
            //rimuovo la riga su cui è stato premuto il tasto cancella
            current_tr.remove();
        }

    });

    $(document).on('change','form select[id=selectMatch]',function(){
            var selectOptionTicket = $(this).parent().parent().find('td select:last');
            $.post(
                "{{ URL::to('matches/findTicket')}}",
                {
                    /*
                     quando safari rendereizza il form stranamente lo chiude immediatamente, mettendo gli input al di fuori
                     dei tag del form, visto che il token non si trova all'interno del form, devo cercarlo sull'intera pagina.
                     */
                    "_token": $('input[name=_token]:first').val(),
                    "match_id": $(this).val() //match_id selezionato
                },
                function( ticketData ) {
                    clearTicketOption(selectOptionTicket);

                    if(ticketData.length > 0 )
                        addSelectOptionTo(selectOptionTicket,ticketData);
                },
                'json'
            );

    });

    function clearTicketOption(selectOption){
        $(selectOption).find('option').remove();
    }

    function addSelectOptionTo(selectOptionTicket,tickets){
        tickets.forEach(function(ticket){
            $(selectOptionTicket).append("<option value='"+ticket.id_ticket+"'>"+ticket.label+"</option>");
        });
    }
</script>
@stop


@section('navigation')
@parent
@stop


@section('content')
<h1>Add Payment</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::open(array('url' => 'payments','class' => 'form-inline')) }}

<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>User</th>
        <th>Quantity</th>
        <th>Match</th>
        <th>Ticket</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td>
            {{ Form::select('user_id[]', $users) }}
        </td>
        <td>
            {{ Form::text('quantity[]', Input::old('quantity'), array('class' => 'form-control','placeholder' => 'Quantity')) }}
        </td>
        <td>
            {{ Form::select('match_id[]', $matches ,'', ['id' => 'selectMatch']) }}
        </td>
        <td>
            {{ Form::select('ticket_id[]', array('' => '')) }}
        </td>
        <td>
            {{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addOrder'])}}
            {{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteOrder'])}}
        </td>
    </tr>
    </tbody>
</table>

{{ Form::submit('Create Tickets!', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop
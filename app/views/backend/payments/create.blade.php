@extends('layouts.master')

@section('head')
@parent
<script>
    /* in default_tr memorizzo html dell'unica riga presente nella tabella,
        questo mi permettera di fare 'aggiunta' di righe senza dover riscrivere l'intero html
    */
    var default_tr = null;
    window.onload=function(){
       loadTicketOption($('table select:first'));

    };

    $(document).on('click','#addOrder',function(){

        //body della tabella
        var tableBody = $('table tbody:first');

        //rimuovo il bottone (add)
        $(this).remove();

        //aggiunto riga alla tabella
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

    function clearTicketOption(selectOption){
        $(selectOption).find('option').remove();
    }

    function loadTicketOption(optionMatch){
        /*
          se la chiamata avviene in seguito all'evento onChange, bisogna convertirlo.
          se la chiamata avviene xk è appena stata caricata la pagina, il parametor passato è gia jquery
         */
        if(!(optionMatch instanceof $) )
            optionMatch = $(optionMatch);

            var selectOptionTicket = optionMatch.parent().parent().find('td select:eq(-2)');

        $.post(
            "{{ URL::to('admin/matches/findTicket')}}",
            {
                /*
                 quando safari rendereizza il form stranamente lo chiude immediatamente, mettendo gli input al di fuori
                 dei tag del form, visto che il token non si trova all'interno del form, devo cercarlo sull'intera pagina.
                 */
                "_token": $('input[name=_token]:first').val(),
                "match_id": optionMatch.val() //match_id selezionato
            },
            function( ticketData ) {
                clearTicketOption(selectOptionTicket);

                if(ticketData.length > 0 )
                    addSelectOptionTo(selectOptionTicket,ticketData);
                loadTicketQuantity(selectOptionTicket);
            },
            'json'
        );
    }

    function loadTicketQuantity(optionTicket){

        if(!(optionTicket instanceof $) )
            optionTicket = $(optionTicket);

        var selectQuantityTicket = optionTicket.parent().parent().find('td select:last');

        $.post(
            "{{ URL::to('admin/tickets/findQuantity')}}",
            {
                /*
                 quando safari rendereizza il form stranamente lo chiude immediatamente, mettendo gli input al di fuori
                 dei tag del form, visto che il token non si trova all'interno del form, devo cercarlo sull'intera pagina.
                 */
                "_token": $('input[name=_token]:first').val(),
                "ticket_id": optionTicket.val() //match_id selezionato
            },
            function( ticketQuantity ) {

                clearTicketOption(selectQuantityTicket);
                addSelectOptionToQuantity(selectQuantityTicket,ticketQuantity);
            },
            'json'
        );
    }

    /*
        Riempe la quantità di ticket disponibili
     */
    function addSelectOptionToQuantity(selectQuantityTicket,tickets){

            for(var i=1 ; i < Math.round(tickets)+1 ;i++){

                selectQuantityTicket.append("<option value='"+i+"'>"+i+"</option>");
            }

        if(default_tr == null)
            default_tr = $('table tbody:first').clone();
    }

    /*
        Popola la select dei ticket
     */
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

@section('header-title')
<h1>Add New Payment
    <small></small>
</h1>
@stop

@section('content')

{{ Form::open(array('url' => 'admin/payments','class' => 'form-inline')) }}

<h4>User: {{ Form::select('user_id', $users , null, ['class' => 'form-control']) }}</h4>
<h4>Date:  {{ Bootstrap::date('pay_date', '',Input::old('pay_date'), $errors,['class' =>'form-control datepicker'])}}</h4>
<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>Match</th>
        <th>Ticket</th>
        <th>Quantity</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td>
            {{ Form::select('match_id[]', $matches ,'', ['onChange' => 'loadTicketOption(this)', 'class' => 'form-control']) }}
        </td>
        <td>
            {{ Form::select('ticket_id[]', array('' => ''),null,['class' => 'form-control','onChange' => 'loadTicketQuantity(this)']) }}
        </td>
        <td>
            {{ Form::selectRange('quantity[]', 1, 10,1,['class' => 'form-control',]) }}
        </td>
        <td>
            {{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addOrder'])}}
            {{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteOrder'])}}
        </td>
    </tr>
    </tbody>
</table>
<p>{{ Form::checkbox('send_notification','yes',false)}} Send Mail to User</p>
<p>{{ Form::checkbox('remove_ticket','yes',true)}} Remove quantity from available Tickets</p>
{{ Form::button(FA::icon('check').' Create Tickets!', array('class' => 'btn btn-success','type' => 'submit')) }}

{{ Form::close() }}

@stop
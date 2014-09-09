@extends('layouts.master')

    @section('head')
        @parent
<script>

    /* in default_tr memorizzo html dell'unica riga presente nella tabella,
     questo mi permettera di fare 'aggiunta' di righe senza dover riscrivere l'intero html
     */
    var default_tr;
    $(function(){
        default_tr = $('table tbody:first').clone();
    });

    $(document).on('click','#addTeam',function(){
        var tableBody = $('table tbody:first');//prendo il tbody

        //rimuovo il bottone (add) dalla riga corrente (verrà aggiunto nella riga successiva)
        $(this).remove();

        tableBody.append(default_tr.html());
    });

    $(document).on('click','#deleteTeam',function(){
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
                var addMatch = '{{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addTeam'])}}';
                var deleteMatch ='{{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteTeam'])}}';

                //prelevo ultimo td della PENULTIMA riga (devo ri-aggiungere il bottone add)
                var last_td = $('table.table tbody tr').eq(-2).find('td:last');
                last_td.html(addMatch+' '+deleteMatch);
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
<h1>Add New Team
    <small></small>
</h1>
@stop

@section('content')

{{ Form::open(array('url' => 'admin/teams','class' => 'form-inline')) }}

<table class="table">
    <thead>
    <tr>
        <th>Team Name</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            {{ Form::text('name[]', Input::old('name'), array('class' => 'form-control','placeholder' => 'Home Team')) }}
        </td>
        <td>
            {{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addTeam'])}}
            {{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteTeam'])}}
        </td>
    </tr>
    </tbody>
</table>

{{ Form::button(FA::icon('check').' Create Team!', array('class' => 'btn btn-success')) }}

{{ Form::close() }}

@stop
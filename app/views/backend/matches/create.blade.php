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

        $(document).on('click','#addMatch',function(){
            var tableBody = $('table tbody:first');//prendo il tbody

            //rimuovo il bottone (add) dalla riga corrente (verrà aggiunto nella riga successiva)
            $(this).remove();

            tableBody.append(default_tr.html());
        });

        $(document).on('click','#deleteMatch',function(){
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
                    var addMatch = '{{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addMatch'])}}';
                    var deleteMatch ='{{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteMatch'])}}';

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
    <h1>Add New Match
        <small></small>
    </h1>
    @stop
    @section('content')

        {{ Form::open(array('url' => 'admin/matches',
                            'class' => 'form-inline')) }}

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Home Team</th>
                    <th>Guest Team</th>
                    <th>Stadium</th>
                    <th>Date</th>
                    <th>Event</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>

                        {{ Form::select('home_id[]',$teams,null,['class' => 'form-control']) }}
                    </td>
                    <td>
                        {{ Form::select('guest_id[]',$teams,null,['class' => 'form-control']) }}
                    </td>
                    <td>
                        {{ Form::text('stadium[]', Input::old('stadium'), array('class' => 'form-control',
                        'placeholder' => 'Stadium')) }}
                    </td>
                    <td>
                        {{ Form::input('text','date[]',null,['class' => 'form-control datepicker','placeholder' =>'Date']) }}
                    </td>
                    <td>
                        {{ Form::select('category_id[]', $category, null, ['class' => 'form-control']) }}
                    </td>
                    <td>
                        {{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addMatch'])}}
                        {{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteMatch'])}}
                    </td>
                </tr>
            </tbody>
        </table>

        {{ Form::button(FA::icon('check').' Create Match!', array('class' => 'btn btn-success','type' => 'submit'))}}

        {{ Form::close() }}

    @stop
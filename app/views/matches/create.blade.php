@extends('layouts.master')

    @section('head')
        @parent
    <script>
        $(document).on('click','.datepicker',function(){
            $(this).datetimepicker({ pickTime: false, format: "DD-MM-YYYY" });
        });

        $(document).on('click','#addMatch',function(){
            var tableBody = $('table tbody');//prendo il tbody
            var home_team = '<input class="form-control" placeholder="Home Team" name="home_team[]" type="text"></div>';
            var guest_team ='<input class="form-control" placeholder="Guest Team" name="guest_team[]" type="text">';
            var date ='<div class="input-group date"><input class="form-control datepicker" placeholder="Select Date" name="date[]" type="text"><span class="input-group-addon">'
                +'<span class="glyphicon-calendar glyphicon"></span>'+
                '</span></div>';
            var addMatch = '{{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addMatch'])}}';
            var deleteMatch ='{{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteMatch'])}}';

            //rimuovo il bottone (addMatch) dalla riga corrente (verrà aggiunto nella riga successiva
            $(this).remove();
            var index = $('table.table tbody tr').length+1;
            tableBody.append('<tr><td>'+index+'</td><td>'+home_team+'</td><td>'+guest_team+'<td>'+date+'</td><td>'+addMatch+' '+deleteMatch+'</td></tr>');

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


    @section('content')
        <h1>Add Match</h1>

        <!-- if there are creation errors, they will show here -->
        {{ HTML::ul($errors->all()) }}

        {{ Form::open(array('url' => 'matches',
                            'class' => 'form-inline')) }}

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Home Team</th>
                    <th>Guest Team</th>
                    <th>Stadium</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        {{ Form::text('home_team[]', Input::old('home_team'), array('class' => 'form-control',
                        'placeholder' => 'Home Team')) }}
                    </td>
                    <td>
                        {{ Form::text('guest_team[]', Input::old('guest_team'), array('class' => 'form-control',
                        'placeholder' => 'Guest Team')) }}
                    </td>
                    <td>
                        {{ Form::text('stadium[]', Input::old('stadium'), array('class' => 'form-control',
                        'placeholder' => 'Stadium')) }}
                    </td>
                    <td>
                        {{Bootstrap::date('date', '', date('d-m-Y'), $errors, ['name'=>'date','class' => 'form-control datepicker'], ['format' => 'DD-MM-YYYY'])}}
                    </td>
                    <td>
                        {{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addMatch'])}}
                        {{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteMatch'])}}
                    </td>
                </tr>
            </tbody>
        </table>

        <!--
        <div class="form-group">
            {{ Form::text('home_team[]', Input::old('home_team'), array('class' => 'form-control',
                                                                      'placeholder' => 'Home Team')) }}
        </div>

        <div class="form-group">
            {{ Form::text('guest_team[]', Input::old('guest_team'), array('class' => 'form-control',
                                                                        'placeholder' => 'Guest Team')) }}
        </div>
        -->

        <!--
            controllo admin
             per il picker usare: http://amsul.ca/pickadate.js/index.htm

        <div class="form-group">
            {{ Form::label('date', 'Date') }}
            {{ Form::text('date', Input::old('date'), array('class' => 'form-control')) }}
        </div>

        -->

        {{ Form::submit('Create Match!', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    @stop
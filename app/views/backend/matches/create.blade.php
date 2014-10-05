@extends('layouts.master')

    @section('head')
        @parent
    <script>

        /* in default_tr memorizzo html dell'unica riga presente nella tabella,
         questo mi permettera di fare 'aggiunta' di righe senza dover riscrivere l'intero html
         */
        var default_tr;
        var tableBody;

        window.onload = function(){
            changeCategory($('select[id="select_category"]'),false);
            default_tr = $('table tbody:first').clone();
            tableBody = $('table tbody:first');//prendo il tbody
        };

        /*
        Aggiunge Nuova riga alla tabella
        */
        $(document).on('click','#addRow',function(){

            //rimuovo il bottone (add) dalla riga corrente (verrà aggiunto nella riga successiva)
            $(this).remove();

            tableBody.append(default_tr.html());
        });

        $(document).on('click','#deleteRow',function(){
            var current_tr = $(this).closest('tr');
            var last_tr = $(tableBody).find('tr:last');
            var total_row = $(tableBody).find('tr').length;

            //posso cancellare solo se sono presenti + di una riga
            if(total_row >1){
                /*
                se sto eliminando la riga in fondo alla tabella
                devo gestire lo spostamento dell'add e del delete button
                 */
                if(current_tr.is(last_tr)){
                    var addRowButton = '{{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addRow'])}}';
                    var deleteRowButton ='{{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteRow'])}}';

                    //prelevo ultimo td della PENULTIMA riga (devo ri-aggiungere il bottone add)
                    var last_td = $(tableBody).find('tr').eq(-2).find('td:last');
                    last_td.html(addRowButton+' '+deleteRowButton);
                }
                //rimuovo la riga su cui è stato premuto il tasto cancella
                current_tr.remove();
            }

        });

        /*
        quando viene cambiata la categoria selezionata ricarico le sub-categorie
         */
        function changeCategory(selectOption,async){
            var id_category = null;

            var selectOptionSubCategory =$(selectOption).parent().parent().find('select[id="select_subcategory"]');
            $(selectOptionSubCategory).find('option').remove();

            if(selectOption instanceof jQuery)
                id_category = selectOption.val();
            else
                id_category = selectOption.value;

            $.ajax({
                type : "POST",
                url : "{{ URL::to('admin/categories/findSubCategories')}}",
                data:{
                    "id_category": id_category
                },
                async:async
            }).done(function(subcatData){
                if(subcatData.length > 0 )
                    addSelectOptionTo($(selectOptionSubCategory),subcatData);
            })
        }


        function addSelectOptionTo(selectOption,subCategories){
            subCategories.forEach(function(subCategory){
                $(selectOption).append("<option value='"+subCategory.id_subcategory+"'>"+subCategory.name+"</option>");
            });
        }
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
                    <th>Type</th>
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
                        {{ Form::select('category_id[]', $category, null, ['class' => 'form-control','id' =>'select_category','onchange' =>'changeCategory(this,true)']) }}
                    </td>
                    <td>
                    {{ Form::select('subcategory_id[]', [''=>''], null, ['class' => 'form-control','id' =>'select_subcategory']) }}
                    </td>
                    <td>
                        {{ Form::button(FA::icon('plus'), ['class' => 'btn btn-large btn-primary openbutton','id' => 'addRow'])}}
                        {{ Form::button(FA::icon('times'), ['class' => 'btn btn-large btn-danger','id' => 'deleteRow'])}}
                    </td>
                </tr>
            </tbody>
        </table>

        {{ Form::button(FA::icon('check').' Create Match!', array('class' => 'btn btn-success','type' => 'submit'))}}

        {{ Form::close() }}

    @stop
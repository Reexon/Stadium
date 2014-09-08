@extends('layouts.master')

    @section('head')
        @parent
        <script>
                function searchUserRequest(){

                    $.post(
                        $( 'form[name=searchUserForm]' ).prop( 'action' ),//preleva l'attributo "action" del form
                        {
                            /*
                            quando safari rendereizza il form stranamente lo chiude immediatamente, mettendo gli input al di fuori
                            dei tag del form, visto che il token non si trova all'interno del form, devo cercarlo sull'intera pagina.
                             */
                            "_token": $('input[name=_token]:first').val(),
                            "firstname": $( 'input[name=firstname]' ).val(),
                            "lastname": $( 'input[name=lastname]' ).val(),
                            "email": $( 'input[name=email]' ).val()
                        },
                        function( userData ) {
                            clearTableBody('table tbody');
                            if(userData.length > 0 )
                                addNewLineToTable(userData,'table tbody');
                        },
                        'json'
                    );
                    return false;
                }

                function clearTableBody(body){
                    $(body+" tr").remove();
                }
                function addNewLineToTable(user,selectorTable){

                    //TODO: Da aggiungere i bottoni dei action
                    user.forEach(function(dataUser){
                        $(selectorTable).append('<tr>' +
                            '<td>'+dataUser.id_user+'</td>'+
                            '<td>'+dataUser.firstname+'</td>' +
                            '<td>'+dataUser.lastname+'</td>' +
                            '<td>'+dataUser.email+'</td>' +
                            '<td>'+dataUser.created_at+'</td>' +
                            '<td>'+showButton(dataUser.id_user)+
                                    editButton(dataUser.id_user)+
                                    deleteButton(dataUser.id_user)+
                            '</td>' +
                            '</tr>');
                    });

                }

            function showButton(id_user){

                return "<a class='btn btn-small btn-success' href=\"<?=URL::to('admin/users/')?>/"+id_user+"\">" +
                    "<i class=\"fa fa-eye\"></i>" +
                    "</a>";
            }
            function editButton(id_user){

                return "<a class='btn btn-small btn-info' href=\"<?=URL::to('admin/users/')?>/"+id_user+"/edit\">" +
                    "<i class=\"fa fa-pencil\"></i>" +
                    "</a>";
            }
                //TODO:bisogna inserire il form qua
            function deleteButton(id_user){
                return "<a class='btn btn-small btn-danger' href=\"<?=URL::to('admin/users/')?>/"+id_user+"\">" +
                    "<i class=\"fa fa-trash-o\"></i>" +
                    "</a>";
            }

        </script>
    @stop


    @section('navigation')
        @parent
    @stop


    @section('header-title')
    <h1>All Registered Users
        <small></small>
    </h1>
    @stop

    @section('content')

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            {{ Form::open(array('url' => 'admin/users/search','style' =>'display:inline-block','name' => 'searchUserForm','method'=>'POST')) }}
            <th></th>
            <th>{{ Form::text('firstname', null, array('class'=>'form-control', 'placeholder'=>'Search First Name','onChange' => 'searchUserRequest()')) }}</th>
            <th>{{ Form::text('lastname', null, array('class'=>'form-control', 'placeholder'=>'Search Last Name','onChange' => 'searchUserRequest()')) }}</th>
            <th>{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Search Email','onChange' => 'searchUserRequest()')) }}</th>
            <th></th>
            <th></th>
            {{ Form::close() }}
        </tr>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Register Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->id_user }}    </td>
        <td>{{ $user->firstname }}  </td>
        <td>{{ $user->lastname }}   </td>
        <td>{{ $user->email }}      </td>
        <td>{{ $user->created_at->format('m-d-Y') }} </td>

        <td>
            <!-- GET /nerds/{id} -->
            <a class="btn btn-small btn-success" href="{{ URL::to('admin/users/' . $user->id_user) }}">{{ FA::icon('eye'); }}</a>

            <!-- GET /nerds/{id}/edit -->
            <a class="btn btn-small btn-info" href="{{ URL::to('admin/users/' . $user->id_user . '/edit') }}">{{ FA::icon('pencil'); }}</a>

            <!-- TODO: Confirmation Before Delete -->
            {{ Form::open(array('url' => 'admin/users/' . $user->id_user,'style' =>'display:inline-block','method' => 'DELETE')) }}
            {{ Form::button(FA::icon('trash-o'), array('type' => 'submit', 'class' => 'btn btn-small btn-danger'))}}
            {{ Form::close() }}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
    @stop
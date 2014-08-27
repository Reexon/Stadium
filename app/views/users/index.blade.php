@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop


    @section('content')

<h1>Users</h1>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <td>ID</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Email</td>
        <td>Register Date</td>
        <td>Actions</td>
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
            <a class="btn btn-small btn-success" href="{{ URL::to('users/' . $user->id_user) }}">{{ FA::icon('eye'); }}</a>

            <!-- GET /nerds/{id}/edit -->
            <a class="btn btn-small btn-info" href="{{ URL::to('users/' . $user->id_user . '/edit') }}">{{ FA::icon('pencil'); }}</a>

            <!-- TODO: Confirmation Before Delete -->
            {{ Form::open(array('url' => 'users/' . $user->id_user,'style' =>'display:inline-block')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::button(FA::icon('trash-o'), array('type' => 'submit', 'class' => 'btn btn-small btn-danger'))}}

            {{ Form::close() }}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
    @stop
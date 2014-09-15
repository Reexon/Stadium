@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop

    @section('header-title')
    <h1>All Matches of {{ $team->name }}
        <small>#{{$team->id_team}}</small>
    </h1>
    @stop

    @section('content')

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <!--TODO:da costruire controller con il metodo per la ricerca-->
        {{Form::open(['url' =>'admin/teams/'.$team->id_team.'/search', 'method' => 'GET'])}}
        <th>

        </th>
        <th>
            {{Form::text('home_team',Input::old('home_team'),['class' => 'form-control'])}}
        </th>
        <th>
            {{Form::text('guest_team',Input::old('guest_team'),['class' => 'form-control'])}}
        </th>
        <th>
            {{Form::text('stadium',Input::old('stadium'),['class' => 'form-control'])}}
        </th>
        <th>
            {{Form::text('date',Input::old('date'),['class' => 'form-control'])}}
        </th>
        <th></th>
        {{Form::close()}}
    </tr>
    <tr>
        <th>ID</th>
        <th>Home</th>
        <th>Guest</th>
        <th>Stadium</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>

    @foreach($team->matchesHome as $match)
    <tr>
        <td>{{ $match->id_event }}</td>

        <td>{{ $match->homeTeam->name }}</td>
        <td>{{ $match->guestTeam->name }}</td>
        <td>{{ $match->stadium }}</td>
        <td>{{ $match->date->format('d-m-Y') }}</td>
        <td>
            <a class="btn btn-small btn-success" href="{{ URL::to('admin/matches/' . $match->id_event) }}">{{ FA::icon('eye'); }}</a>
            <a class="btn btn-small btn-info" href="{{ URL::to('admin/matches/' . $match->id_event . '/edit') }}">{{ FA::icon('pencil'); }}</a>
        </td>
    </tr>
    @endforeach
    @foreach($team->matchesGuest as $match)
    <tr>
        <td>{{ $match->id_event }}</td>

        <td>{{ $match->homeTeam->name }}</td>
        <td>{{ $match->guestTeam->name }}</td>
        <td>{{ $match->stadium }}</td>
        <td>{{ $match->date->format('d-m-Y') }}</td>
        <td>
            <a class="btn btn-small btn-success" href="{{ URL::to('admin/matches/' . $match->id_event) }}">{{ FA::icon('eye'); }}</a>
            <a class="btn btn-small btn-info" href="{{ URL::to('admin/matches/' . $match->id_event . '/edit') }}">{{ FA::icon('pencil'); }}</a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

@stop
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
        <td>{{ $match->id_match }}</td>

        <td>{{ $match->homeTeam->name }}</td>
        <td>{{ $match->guestTeam->name }}</td>
        <td>{{ $match->stadium }}</td>
        <td>{{ $match->date->format('d-m-Y') }}</td>
        <td>
            <a class="btn btn-small btn-success" href="{{ URL::to('admin/matches/' . $match->id_match) }}">{{ FA::icon('eye'); }}</a>
            <a class="btn btn-small btn-info" href="{{ URL::to('admin/matches/' . $match->id_match . '/edit') }}">{{ FA::icon('pencil'); }}</a>
        </td>
    </tr>
    @endforeach
    @foreach($team->matchesGuest as $match)
    <tr>
        <td>{{ $match->id_match }}</td>

        <td>{{ $match->homeTeam->name }}</td>
        <td>{{ $match->guestTeam->name }}</td>
        <td>{{ $match->stadium }}</td>
        <td>{{ $match->date->format('d-m-Y') }}</td>
        <td>
            <a class="btn btn-small btn-success" href="{{ URL::to('admin/matches/' . $match->id_match) }}">{{ FA::icon('eye'); }}</a>
            <a class="btn btn-small btn-info" href="{{ URL::to('admin/matches/' . $match->id_match . '/edit') }}">{{ FA::icon('pencil'); }}</a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

@stop
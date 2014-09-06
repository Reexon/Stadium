@extends('layouts.master')

@section('head')
    @parent
@stop

@section('navigation')
@parent
@stop

@section('content')

    <h1>All Matches</h1>

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
        @foreach($matches as $match)
        <tr>
            <td>{{ $match->id_match }}</td>
            <td><a href="{{ URL::to('admin/teams/'.$match->homeTeam->id_team)}}">{{ $match->homeTeam->name }}</a></td>
            <td><a href="{{ URL::to('admin/teams/'.$match->guestTeam->id_team)}}">{{ $match->guestTeam->name }}</a></td>
            <td>{{ $match->stadium }}</td>
            <td>{{ $match->date->format('d-m-Y') }}</td>

            <td>
                <!-- GET /nerds/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('admin/matches/' . $match->id_match) }}">{{ FA::icon('eye'); }}</a>

                <!-- GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('admin/matches/' . $match->id_match . '/edit') }}">{{ FA::icon('pencil'); }}</a>

                <!-- TODO: Confirmation Before Delete -->
                {{ Form::open(array('url' => 'admin/matches/' . $match->id_match,'style' =>'display:inline-block')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::button(FA::icon('trash-o'), array('type' => 'submit', 'class' => 'btn btn-small btn-danger'))}}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    {{ $matches->links() }}
@stop
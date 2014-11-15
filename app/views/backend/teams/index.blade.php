@extends('layouts.backend.master')

    @section('title')
    All Teams
        <a href="{{URL::to('admin/teams/create')}}" class="btn btn-sm btn-primary">{{FA::icon('plus')}}</a>
        <small></small>

    @stop

    @section('content')

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Team</th>
            </tr>
        </thead>
        <tbody>
        @foreach($teams as $team)
            <tr>
                <td>{{ $team->id_team }}</td>
                <td><a href="{{URL::to('admin/teams/'.$team->id_team)}}">{{ $team->name}} </a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$teams->links()}}
@stop
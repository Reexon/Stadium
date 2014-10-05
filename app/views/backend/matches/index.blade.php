@extends('layouts.master')

@section('head')
    @parent
@stop

@section('navigation')
@parent
@stop
@section('header-title')
<h1>Display All Matches
    <a href="{{URL::to('admin/matches/create')}}" class="btn btn-sm btn-primary">{{FA::icon('plus')}}</a>
    <small></small>
</h1>
@stop
@section('content')

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
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
            <td><a href="{{ URL::to('admin/teams/'.$match->homeTeam->id_team)}}">{{ $match->homeTeam->name }}</a></td>
            <td><a href="{{ URL::to('admin/teams/'.$match->guestTeam->id_team)}}">{{ $match->guestTeam->name }}</a></td>
            <td>{{ $match->stadium }}</td>
            <td>{{ $match->date->format('d-m-Y') }}</td>

            <td>
                <!-- GET /nerds/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('admin/matches/' . $match->id_event) }}">{{ FA::icon('eye'); }}</a>

                <!-- GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('admin/matches/' . $match->id_event . '/edit') }}">{{ FA::icon('pencil'); }}</a>

                <!-- TODO: Confirmation Before Delete -->
                {{ Form::open(array('url' => 'admin/matches/' . $match->id_event,'style' =>'display:inline-block')) }}
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
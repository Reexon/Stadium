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
    </tr>
    </thead>

    <tbody>
    @foreach($matches as $match)
        <tr>
            <td>{{ $match->id_match }}</td>
            <td>{{ $match->homeTeam->name }}</td>
            <td>{{ $match->guestTeam->name }}</td>
            <td>{{ $match->stadium }}</td>
            <td>{{ $match->date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $matches->links() }}
@stop
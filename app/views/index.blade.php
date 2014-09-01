@extends('layouts.frontend')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

<table class="table ">
    <thead>
        <tr>
            <th>Match</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($matches as $match)
            <tr>
                <td>{{$match->home_team }} vs {{ $match->guest_team}}</td>
                <td>{{$match->date->format('d-m-Y')}}</td>
                <td><a href="{{URL::to('match/info/'.$match->id_match)}}" class="btn btn-small btn-success">{{FA::icon('eye')}}</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop
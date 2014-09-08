@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

<div class="row">
    <div class="col-md-5">
        <div class="box box-primary">
            <div class="box-header">

                <div class="box-title">Next 10 Matches</div>
            </div>
            <div class="box-body">
                <table class="table">
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
                                <td>
                                        {{$match->homeTeam->name }} vs {{ $match->guestTeam->name}}
                                </td>
                                <td>{{$match->date->format('d-m-Y')}}</td>
                                <td><a href="{{URL::to('match/info/'.$match->id_match)}}" class="btn btn-small btn-success">{{FA::icon('eye')}}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
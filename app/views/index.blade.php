@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">

                <div class="box-title">Next Football Matches</div>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Match</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matches as $match)
                            <tr>
                                <td>
                                    {{FA::icon('soccer-ball-o')}} {{$match->homeTeam->name }} vs {{ $match->guestTeam->name}}
                                </td>
                                <td>{{$match->date->format('d-m-Y')}}</td>
                                <td><a href="{{URL::to('event/info/'.$match->category_id.'/'.$match->id_event)}}" class="btn btn-small btn-success">{{FA::icon('eye')}}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$matches->links()}}
            </div>
        </div>
    </div><!-- ./col-md-* -->

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">

                <div class="box-title">Next Concert</div>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($concerts as $concert)
                    <tr>
                        <td>
                          {{FA::icon('microphone')}}  {{$concert->artist->name }}
                        </td>
                        <td>{{$concert->date->format('d-m-Y')}}</td>
                        <td><a href="{{URL::to('event/info/'.$concert->category_id.'/'.$concert->id_event)}}" class="btn btn-small btn-success">{{FA::icon('eye')}}</a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$concerts->links()}}
            </div>
        </div>
    </div>
</div>
@stop
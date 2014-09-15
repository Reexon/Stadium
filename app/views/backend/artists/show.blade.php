@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>All Concerts of {{ $artist->name }}
    <small>#{{$artist->id_team}}</small>
</h1>
@stop

@section('content')

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <!--TODO:da costruire controller con il metodo per la ricerca-->
        {{Form::open(['url' =>'admin/artists/'.$artist->id_team.'/search', 'method' => 'GET'])}}
        <th>

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
        <th>Stadium</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>

    @foreach($artist->concerts as $concert)
    <tr>
        <td>{{ $concert->id_event }}</td>
        <td>{{ $concert->stadium }}</td>
        <td>{{ $concert->date->format('d-m-Y') }}</td>
        <td>
            <a class="btn btn-small btn-success" href="{{ URL::to('admin/concerts/' . $concert->id_event) }}">{{ FA::icon('eye'); }}</a>
            <a class="btn btn-small btn-info" href="{{ URL::to('admin/concerts/' . $concert->id_event . '/edit') }}">{{ FA::icon('pencil'); }}</a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

@stop
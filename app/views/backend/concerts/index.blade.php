@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop
@section('header-title')
<h1>Display All Concerts
    <a href="{{URL::to('admin/concerts/create')}}" class="btn btn-sm btn-primary">{{FA::icon('plus')}}</a>
    <small></small>
</h1>
@stop
@section('content')

<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Home</th>
        <th>Stadium</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($concerts as $concert)
    <tr>
        <td>{{ $concert->id_event }}</td>
        <td><a href="{{ URL::to('admin/artists/'.$concert->artist->id_team)}}">{{ $concert->artist->name }}</a></td>
        <td>{{ $concert->stadium }}</td>
        <td>{{ $concert->date->format('d-m-Y') }}</td>

        <td>
            <!-- GET /nerds/{id} -->
            <a class="btn btn-small btn-success" href="{{ URL::to('admin/concerts/' . $concert->id_event) }}">{{ FA::icon('eye'); }}</a>

            <!-- GET /nerds/{id}/edit -->
            <a class="btn btn-small btn-info" href="{{ URL::to('admin/concerts/' . $concert->id_event . '/edit') }}">{{ FA::icon('pencil'); }}</a>

            <!-- TODO: Confirmation Before Delete -->
            {{ Form::open(array('url' => 'admin/concerts/' . $concert->id_event,'style' =>'display:inline-block')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::button(FA::icon('trash-o'), array('type' => 'submit', 'class' => 'btn btn-small btn-danger'))}}
            {{ Form::close() }}
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

{{ $concerts->links() }}
@stop
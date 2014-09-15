@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('header-title')
<h1>All Artists
    <a href="{{URL::to('admin/artists/create')}}" class="btn btn-sm btn-primary">{{FA::icon('plus')}}</a>
    <small></small>
</h1>
@stop

@section('content')


<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Artist</th>
    </tr>
    </thead>
    <tbody>
    @foreach($artists as $artist)
    <tr>
        <td>{{ $artist->id_artist }}</td>
        <td><a href="{{URL::to('admin/artists/'.$artist->id_artist)}}">{{ $artist->name}} </a></td>
    </tr>
    @endforeach
    </tbody>
</table>

{{$artists->links()}}
@stop
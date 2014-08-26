@extends('layouts.master')

@section('head')
    @parent
@stop

@section('navigation')
@parent
@stop

@section('content')

    <h1>All Matchs</h1>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>ID</td>
            <td>Home</td>
            <td>Guest</td>
            <td>Date</td>
            <td>Actions</td>
        </tr>
        </thead>
        <tbody>
        @foreach($matches as $key => $value)
        <tr>
            <td>{{ $value->id_match }}</td>
            <td>{{ $value->home_team }}</td>
            <td>{{ $value->guest_team }}</td>
            <td>{{ $value->date }}</td>


            <td>
                <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('matches/' . $value->id_match) }}">{{ FA::icon('eye'); }}</a>

                <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('matches/' . $value->id_match . '/edit') }}">{{ FA::icon('pencil'); }}</a>

                <!-- TODO: Confirmation Before Delete -->
                {{ Form::open(array('url' => 'matches/' . $value->id_match,'style' =>'display:inline-block')) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::button(FA::icon('trash-o'), array('type' => 'submit', 'class' => 'btn btn-small btn-danger'))}}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@stop
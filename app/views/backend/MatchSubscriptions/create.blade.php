@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop


    @section('header-title')
    <h1>
        Title
        <small></small>
    </h1>
    @stop

    @section('content')
{{Form::open(['url' => 'admin/MatchSubscriptions'])}}
<div class="col-md-offset-4 col-md-4">
        <div class="box box-title box-success">
            <div class="box-header">
                <div class="box-title">
                    Insert New Subscriber
                </div>
            </div>
            <div class="box-body">
                <label>Select Match:</label>
                {{Form::select('event_id',$matches,1,['class' => 'form-control'])}}
                <label>Mail:</label>
                {{Form::email('email',Input::old('email'),['class' => 'form-control'])}}
            </div>
            <div class="box-footer">
                {{Form::submit('Add To Subscriber',['class' =>'btn btn-success'])}}
            </div>
        </div>
</div>
{{Form::close()}}
    @stop
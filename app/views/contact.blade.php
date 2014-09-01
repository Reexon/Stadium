@extends('layouts.frontend')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

<div class="panel panel-danger">
    <div class="panel-heading">Panel heading without title</div>
    <div class="panel-body">asd
    </div>
</div>
{{ Form::open(array('url'=>'backend/mails/send')) }}
<h4>Title</h4>
{{Form::text('title',Input::old('title'),['placeholder' => 'title', 'class' =>'form-control input-lg'])}}

<h4>To</h4>
{{Form::text('to',Input::old('to'),['placeholder' => 'To', 'class' =>'form-control input-lg'])}}

<h4>Subject</h4>
{{Form::text('subject',Input::old('subject'),['placeholder' => 'Subject', 'class' =>'form-control input-lg'])}}

<h4>Body</h4>
{{Form::textarea('body',null,['class' => 'form-control','rows' => 10]) }}

{{ Form::submit('Send Mail!', array('class' => 'btn btn-primary btn-lg btn-block btn-success')) }}
@stop
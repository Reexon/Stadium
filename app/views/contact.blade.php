@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')


{{ Form::open(array('url'=>'backend/mails/send')) }}
<h4>Title</h4>
{{Form::text('title',Input::old('title'),['placeholder' => 'title', 'class' =>'form-control input-lg'])}}

<h4>Your Email</h4>
{{Form::text('email',Input::old('email'),['placeholder' => 'email', 'class' =>'form-control input-lg'])}}

<h4>Subject</h4>
{{Form::text('subject',Input::old('subject'),['placeholder' => 'Subject', 'class' =>'form-control input-lg'])}}

<h4>Body</h4>
{{Form::textarea('body',null,['class' => 'form-control','rows' => 10]) }}

{{ Form::submit('Send Mail!', array('class' => 'btn btn-primary btn-lg btn-block btn-success')) }}
@stop
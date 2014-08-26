@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop


    @section('content')
        {{ Form::open(array('url'=>'users', 'class'=>'form-signup')) }}
        <h2 class="form-signup-heading">Register</h2>

        {{ Form::text('firstname', null, array('class'=>'input-block-level', 'placeholder'=>'First Name')) }}
        {{ Form::text('lastname', null, array('class'=>'input-block-level', 'placeholder'=>'Last Name')) }}
        {{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
        {{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}
        {{ Form::password('password_confirmation', array('class'=>'input-block-level', 'placeholder'=>'Confirm Password')) }}

        {{ Form::submit('Register', array('class'=>'btn btn-large btn-primary btn-block'))}}
        {{ Form::close() }}
    @stop
@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')

    <!--login modal-->
    @if(!Auth::check())
        {{ Form::open(array('url'=>'login', 'class'=>'form col-md-12 center-block')) }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="text-center">Login</h1>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        {{ Form::text('email', null, array('class'=>'form-control input-lg', 'placeholder'=>'Email Address')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::password('password', array('class'=>'form-control input-lg', 'placeholder'=>'Password')) }}
                    </div>
                    <div class="form-group">
                        <span class="pull-right"><a href="{{ URL::to('users/create') }}">Register</a></span><span><a href="#">Forgot Password?</a></span>

                        {{ Form::submit('Login', array('class'=>'btn btn-lg btn-primary btn-block'))}}
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    @endif
@stop
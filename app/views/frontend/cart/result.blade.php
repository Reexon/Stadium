@extends('layouts.master')

@section('head')
@parent
{{HTML::style('css/ProgressTracker.css')}}
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>Transaction asd{{Input::get('transid')}}
    <small></small>
</h1>
@stop

@section('content')
<div style="margin-bottom: 25px;">
    <ol class="progtrckr" data-progtrckr-steps="5">
        <li class="progtrckr-done"><b>Check Your Cart</b></li>
        <li class="progtrckr-done">Personal Info</li>
        <li class="progtrckr-done">Review</li>
        <li class="progtrckr-done">Checkout</li>
        <li class="progtrckr-current">Receipt</li>
    </ol>
</div>

Transaction ID(Assegnato dal cons): {{Input::get('TransID')}}
Track ID: {{Input::get('TrackID')}}
Payment ID(Interno) : {{Input::get('PaymentID')}}
Result: {{Input::get('resultCode')}}
Card Type: {{Input::get('cardtype')}}
Auth Code : {{Input::get('auth')}}
Date : {{Input::get('postdate')}}
User Id: {{Input::get('user_id')}}
@stop
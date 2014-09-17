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
@if(Input::get('resultcode')=="APPROVED")
    <h1> Your Order has been placed !</h1>
@else
    <h1> Error Encountered During Payment Process, Trackid: {{Input::get('trackid')}}</h1>
    Please Contact The Adminsitrator <a href="mailto:info@stadium.it">info@stadium.it</a>
@endif
Email will be sent to you
{{Input::get('email')}}-
{{Input::get('mobile')}}-
{{Input::get('firstname')}}-
{{Input::get('lastname')}}-
Transaction ID(Assegnato dal cons): {{Input::get('TransID')}}
Track ID: {{Input::get('trackid')}}
Payment ID(Interno) : {{Input::get('PaymentID')}}
Result: {{Input::get('resultcode')}}
Card Type: {{Input::get('cardtype')}}
Auth Code : {{Input::get('auth')}}
Date : {{Input::get('postdate')}}
@stop
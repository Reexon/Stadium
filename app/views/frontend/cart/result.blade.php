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
@if($payment->status =="APPROVED")
    <h1> Your Order has been placed !</h1>
@elseif($payment->status == "NOT APPROVED")
    <h1> Error Encountered During Payment Process, Trackid: {{$payment->trackid}}</h1>
    Please Contact The Adminsitrator <a href="mailto:info@stadium.it">info@stadium.it</a>
@endif

@if($errorText != "")
    <h1>{{$errorText}}</h1>
@else
    Email will be sent to you
    {{$user->email}}<br>
    {{$user->mobile}}<br>
    {{$user->firstname}}<br>
    {{$user->lastname}}<br>
    {{$user->addresss}}<br>
    {{$user->city}}<br>

    Transaction ID(Assegnato dal cons): {{Input::get('TransID')}}
    Track ID: {{Input::get('trackid')}}
    Payment ID(Interno) : {{Input::get('PaymentID')}}
    Result: {{Input::get('resultcode')}}
    Card Type: {{Input::get('cardtype')}}
    Auth Code : {{Input::get('auth')}}
    Date : {{Input::get('postdate')}}
@endif

@stop
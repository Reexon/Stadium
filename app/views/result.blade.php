@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>Transaction {{Input::get('transid')}}
    <small></small>
</h1>
@stop

@section('content')
Transaction ID(Assegnato dal cons): {{Input::get('TransID')}}
Track ID: {{Input::get('TrackID')}}
Payment ID(Interno) : {{Input::get('PaymentID')}}
Result: {{Input::get('resultcode')}}
Card Type {{Input::get('cardtype')}}
@stop
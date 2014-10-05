@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop

@section('header-title')
<h1>
    Final Consumers <small>Overview</small>
</h1>
@stop
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="box box-solid box-success">
            <div class="box-header">
                <div class="box-title">
                    Buyer Information
                </div>
            </div>
            <div class="box-body">
                <b>Full Name: </b>{{$payment->user->fullname}}<br>
                <b>Address: </b>{{$payment->user->address}}<br>
                <b>Email: </b>{{$payment->user->email}}<br>
                <b>Mobile: </b>{{$payment->user->mobile}}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-solid box-danger">
            <div class="box-header">
                <div class="box-title">
                    Shipping Information
                </div>
            </div>
            <div class="box-body">
                <b>Full Name : </b>{{$payment->fullname}}<br>
                <b>Address:</b> {{$payment->address}}, {{$payment->cap}},{{$payment->city}}<br>
                <b>Email: </b>{{$payment->email}}<br>
                <b>Mobile: </b>{{$payment->mobile}}
            </div>
        </div>
    </div>
</div>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Consumer</th>
            <th>Event</th>
            <th>Born</th>
            <th>Residence</th>
        </tr>
    </thead>
    <tbody>
    @foreach($payment->orders as $order)
        @if(in_array($order->ticket->event->category_id,Backend\Model\Match::$category))
            @foreach($order->consumers as $consumer)
                <tr>
                    <td>{{$consumer->fullname}}</td>
                    <td>{{$order->ticket->match->homeTeam->name}} vs {{$order->ticket->match->guestTeam->name}} - <b>{{$order->ticket->label}}</b></td>
                    <td>{{$consumer->born_date->format('d.m.Y')}} <br>{{$consumer->born_location}}</td>
                    <td>
                        {{$consumer->res_via}}<br>
                        {{$consumer->res_com}},{{$consumer->res_prov}}<br>
                        {{$consumer->res_cap}}
                    </td>
                </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>
@stop
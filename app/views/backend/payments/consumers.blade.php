@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop

@section('header-title')
<h1>
    Final Consumers<small>Overview</small>
</h1>
@stop
@section('content')
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Born</th>
            <th>Residence</th>
        </tr>
    </thead>
    <tbody>
    @foreach($payment->orders as $order)
        @if(in_array($order->ticket->category_id,Backend\Model\Match::$category))
            @foreach($order->consumers as $consumer)
                <tr>
                    <td>{{$consumer->fullname}}</td>
                    <td>{{$consumer->born_date->format('d.m.Y')}} {{$consumer->born_location}}</td>
                    <td>
                        {{$consumser->res_via}}<br>
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
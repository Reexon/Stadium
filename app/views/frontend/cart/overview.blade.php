@extends('layouts.master')

@section('head')
@parent
{{HTML::style('css/ProgressTracker.css')}}
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>Your Cart
    <small></small>
</h1>
@stop

@section('content')
{{ Form::open(['url' => 'cart/buy','class'=>'form-horizontal','role' => 'form']) }}

@if(count($cartItems)>0)

<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>Ticket</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cartItems as $item)
    <tr>
        <td>#{{$item['id_ticket']}}</td>
        <td>{{$item['label']}}</td>
        <td>{{$item['buy_quantity']}}</td>
        <td>{{number_format($item['buy_quantity'] * $item['price'],2,',','.')}} €</td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3"></th>
        <th><b>{{number_format($total_amount,2,',','.')}} €</b></th>
    </tr>
    </tfoot>
</table>

<a href="{{URL::to('cart/clear')}}" class="btn btn-primary">{{FA::icon('trash-o')}} Clear</a>
@else

<div class="alert alert-warning alert-dismissable">
    <i class="fa fa-warning"></i>
    <b>Alert!</b> Please fill your cart before proceed with checkout !
</div>
@endif
{{ Form::button('Checkout',['type' => 'submit','class' =>'btn btn-warning pull-right']) }}
{{ Form::close()}}

@stop
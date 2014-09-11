@extends('layouts.master')

@section('head')
@parent
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
                    <td>{{ Form::selectRange('quantity', 1, $item['quantity'],$item['buy_quantity']) }}</td>
                    <!--TODO: Aggiornamento Prezzo AJAX in base a quando si cambia la quantità-->
                    <td>{{$item['buy_quantity'] * $item['price']}}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
        <a href="{{URL::to('cart/checkout')}}" class="btn btn-warning">Next Step</a>
    <a href="{{URL::to('cart/clear')}}" class="btn btn-primary">Clear</a>
@else

<div class="alert alert-warning alert-dismissable">
    <i class="fa fa-warning"></i>
    <b>Alert!</b> Please fill your cart before proceed with checkout !
</div>
@endif
@stop
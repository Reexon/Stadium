@extends('layouts.frontend')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop


@section('content')
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
                <td>{{$item['buy_quantity'] * $item['price']}}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{URL::to('cart/clear')}}">Clear</a>
@stop
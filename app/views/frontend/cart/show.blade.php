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
<div style="margin-bottom: 25px;">
    <ol class="progtrckr" data-progtrckr-steps="5">
        <li class="progtrckr-current"><b>Check Your Cart</b></li>
        <li class="progtrckr-todo">Personal Info</li>
        <li class="progtrckr-todo">Review</li>
        <li class="progtrckr-todo">Checkout</li>
        <li class="progtrckr-todo">Receipt</li>
    </ol>
</div>
@if(count($cartItems)>0)
    <table class="table">
        <thead>
            <tr>
                <th>Ticket</th>
                <th>Quantity</th>
                <th>Price per one</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
                <tr>
                    <td>{{$item['label']}}</td>
                    <td>{{ Form::selectRange('quantity', 1, $item['quantity'],$item['buy_quantity']) }}</td>
                    <td>{{ number_format($item['price'],2,',','.') }} €</td>
                    <!--TODO: Aggiornamento Prezzo AJAX in base a quando si cambia la quantità-->
                    <td>{{number_format($item['buy_quantity'] * $item['price'],2,',','.')}} €</td>
                    <!--TODO: Bottoni per rimuovere ticket -->
                    <td></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3"></th>
                <th><b>{{number_format($total_amount,2,',',' ')}} €</b></th>
                <th></th>
            </tr>
        </tfoot>
    </table>

        <a href="{{URL::to('cart/clear')}}" class="btn btn-danger">{{FA::icon('trash-o')}} Clear</a>
        <a href="{{URL::to('cart/personalInfo')}}" class="btn btn-warning pull-right">Next Step</a>
@else

<div class="alert alert-warning alert-dismissable">
    <i class="fa fa-warning"></i>
    <b>Alert!</b> Please fill your cart before proceed with checkout !
</div>
@endif
@stop
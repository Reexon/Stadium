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
        <li class="progtrckr-done">Check Your Cart</b></li>
        <li class="progtrckr-done">Personal Info</li>
        <li class="progtrckr-current"><b>Review</b></li>
        <li class="progtrckr-todo">Checkout</li>
        <li class="progtrckr-todo">Receipt</li>
    </ol>
</div>

<!-- Informazioni Generali -->
{{ Form::open(['url' => 'cart/consumerInfo','class'=>'form-horizontal','role' => 'form','method' => 'get']) }}

<div class="row">
    <div class="col-md-5">
        <div class="box box-warning">
            <div class="box-header">
                <div class="box-title">
                    General Info
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        Firstname
                    </label>
                    <div class="col-sm-8">
                        {{Form::text('firstname',Input::get('firstname'),['class' => 'form-control','disabled' => 'disabled'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        Lastname
                    </label>
                    <div class="col-sm-8">
                        {{Form::text('lastname',Input::get('lastname'),['class' => 'form-control','disabled' => 'disabled'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        Email
                    </label>
                    <div class="col-sm-8">
                        {{Form::email('email',Input::get('email'),['class' => 'form-control','disabled' => 'disabled'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        Mobile
                    </label>
                    <div class="col-sm-8">
                        {{Form::text('mobile',Input::get('mobile'),['class' => 'form-control','disabled' => 'disabled'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        Alt. Mobile
                    </label>
                    <div class="col-sm-8">
                        {{Form::text('alt_mobile',Input::get('alt_mobile'),['class' => 'form-control','disabled' => 'disabled'])}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="box box-warning">
            <div class="box-header">
                <div class="box-title">
                    Shipping Info
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        Address
                    </label>
                    <div class="col-sm-8">
                        {{Form::text('address',Input::get('address'),['class' => 'form-control','disabled' => 'disabled'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        City
                    </label>
                    <div class="col-sm-8">
                        {{Form::text('city',Input::get('city'),['class' => 'form-control','disabled' => 'disabled'])}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        CAP/Postal Code
                    </label>
                    <div class="col-sm-8">
                        {{Form::email('cap',Input::get('cap'),['class' => 'form-control','disabled' => 'disabled'])}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
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
        <li class="progtrckr-done"><b>Check Your Cart</b></li>
        <li class="progtrckr-current">Personal Info</li>
        <li class="progtrckr-todo">Review</li>
        <li class="progtrckr-todo">Checkout</li>
        <li class="progtrckr-todo">Receipt</li>
    </ol>
</div>
{{ Form::model(Auth::user(),['url' => 'cart/review','class'=>'form-horizontal','role' => 'form']) }}

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
                            {{Form::text('firstname',Input::old('firstname'),['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Lastname
                        </label>
                        <div class="col-sm-8">
                            {{Form::text('lastname',Input::old('lastname'),['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Email
                        </label>
                        <div class="col-sm-8">
                            {{Form::email('email',Input::old('email'),['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Mobile
                        </label>
                        <div class="col-sm-8">
                            {{Form::text('mobile',Input::old('mobile'),['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            Alt. Mobile
                        </label>
                        <div class="col-sm-8">
                            {{Form::text('alt_mobile',Input::old('alt_mobile'),['class' => 'form-control'])}}
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
                            {{Form::text('address',Input::old('address'),['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            City
                        </label>
                        <div class="col-sm-8">
                            {{Form::text('city',Input::old('city'),['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">
                            CAP/Postal Code
                        </label>
                        <div class="col-sm-8">
                            {{Form::email('cap',Input::old('cap'),['class' => 'form-control'])}}
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
            <td colspan="3"></td>
            <td><b>{{number_format($total_amount,2,',','.')}} €</b></td>
        </tr>
    </tfoot>
</table>


<a href="{{URL::to('cart/clear')}}" class="btn btn-danger">{{FA::icon('trash-o')}} Clear</a>
@else

<div class="alert alert-warning alert-dismissable">
    <i class="fa fa-warning"></i>
    <b>Alert!</b> Please fill your cart before proceed with checkout !
</div>
@endif

{{ Form::button('Checkout',['type' => 'submit','class' =>'btn btn-warning pull-right']) }}
{{ Form::close() }}
@stop
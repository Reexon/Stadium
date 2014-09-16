@extends('layouts.master')

@section('head')
@parent
<style>
    .form-control { width: 100%; }
</style>
@stop


@section('navigation')
@parent
@stop


@section('header-title')
<h1>{{ $user->firstname }} {{ $user->lastname }} <a class="btn btn-small btn-info" href="{{ URL::to('admin/users/'.$user->id_user .'/edit')}}">{{FA::lg('pencil')}}</a>
    <small></small>
</h1>
@stop
@section('content')

<div class="row">

    <div class="col-md-4"><!-- Personal Information -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                Personal Information
            </div>
            <div class="panel-body">
                <p>
                <div class="form-group">
                    <label class="control-label">First Name</label>
                    {{$user->firstname}}
                </div>
                <div class="form-group">
                    <label class="control-label">Lastname</label>
                    {{$user->lastname}}
                </div>
                <div class="form-group">
                    <label class="control-label">Birth Date</label>
                    {{$user->birth_date}}
                </div>
                <div class="form-group">
                    <label class="control-label">Register Date</label>
                    {{$user->created_at->format('d.m.Y')}}
                </div>
                </p>
            </div>
        </div>
    </div><!--./ Personal Information -->

    <div class="col-md-4"><!-- Contact Information -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                Contact Information
            </div>
            <div class="panel-body">
                <p>
                <div class="form-group">
                    <label class="control-label">Mobile</label>
                    {{$user->mobile}}
                </div>
                <div class="form-group">
                    <label class="control-label">Alt. Mobile</label>
                    {{$user->alt_mobile}}
                </div>
                <div class="form-group">
                    <label class="control-label">Email</label>
                    {{$user->email}}
                </div>

                <div class="form-group">
                    <label class="control-label">City</label>
                    {{$user->city}}
                </div>
                </p>
            </div>
        </div>
    </div><!-- ./ Contact Information -->
    <div class="col-md-4"><!-- Shipping Information -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                Shipping Information
            </div>
            <div class="panel-body">
                <p>
                    <div class="form-group">
                        <label class="control-label">City</label>
                        {{$user->city}}
                    </div>
                    <div class="form-group">
                        <label class="control-label">CAP</label>
                        {{$user->cap}}
                    </div>
                    <div class="form-group">
                        <label class="control-label">Address</label>
                        {{$user->address}}
                    </div>
                </p>
            </div>
        </div>
    </div><!-- ./ Contact Information -->
</div>
<div class="row">
    <div class="col-md-4">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-green">
                    <th colspan="3" style="text-align:center;">Purchased Tickets</th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
            @foreach($user->payments as $payment)
                @foreach($payment->orders as $order)
                <tr>
                    <td>{{ $order->id_order }}</td>
                    <td>{{ $order->ticket->label }}</td>
                    <td>{{ $order->quantity }}</td>
                </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <table class="table table-bordered">
            <thead>
            <tr class="bg-yellow">
                <th colspan="3" style="text-align:center;">Payment</th>
            </tr>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($user->payments as $payment)
            <tr>
                <td><a href="{{URL::to('admin/payments/'.$payment->id_payment)}}">#{{ $payment->id_payment }}</a></td>
                <td>{{ $payment->pay_date->format('d.m.Y')}}</td>
                <td>{{ number_format($payment->total,2,',','.')}} €</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
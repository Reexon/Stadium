@extends('layouts.master')

@section('head')
@parent
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>
    Dashboard
    <small>Overview</small>
</h1>
@stop

@section('content')

<div class="row">
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>
                    {{$data['shipCount']}}
                </h3>
                <p>
                    Waiting Shipment
                </p>
            </div>
            <div class="icon">
                {{FA::icon('truck')}}
            </div>
            <a href="{{URL::to('admin/shipments/waiting')}}" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>
                    {{$data['failPayCount']}}
                </h3>
                <p>
                    Error Payment
                </p>
            </div>
            <div class="icon">
                {{FA::icon('bug')}}
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>
                    {{$data['newPayCount']}}
                </h3>
                <p>
                    New Payment
                </p>
            </div>
            <div class="icon">
                {{FA::icon('star')}}
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-info">
            <div class="panel-heading bg-aqua">
                <b>Waiting Shipping</b>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Buyer</th>
                    <th style="text-align:right">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php Paginator::setPageName('pshippings'); ?>
                @foreach($shipPayments as $payment)
                <tr>
                    <td>
                        <a href="{{URL::to('admin/payments/'.$payment->id_payment)}}">{{$payment->id_payment}}</a>
                    </td>
                    <td>
                        <a href="{{URL::to('admin/users/'.$payment->user_id)}}">{{$payment->user->fullname}}</a>
                    </td>
                    <td align="right">{{ number_format($payment->total,2,',','.') }} €</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$shipPayments->appends(['pfailed' => Input::get('pfailed',1)])->links()}}
    </div><!-- ./col -->
    <div class="col-lg-3"><!-- Pagamenti Falliti -->
        <div class="panel panel-danger">
            <div class="panel-heading bg-red">
                <b>Failed Payment</b>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Pay</th>
                    <th style="text-align:right">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php Paginator::setPageName('pfailed'); ?>
                @foreach($failPayments as $payment)
                <tr>
                    <td><a href="{{URL::to('admin/payments/'.$payment->id_payment)}}">{{$payment->id_payment}}</a></td>
                    <td>
                        <span class="label label-danger">Error</span>
                    </td>
                    <td align="right">{{ number_format($payment->total,2,',','.') }} €</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$failPayments->appends(['pshippings' => Input::get('pshippings',1)])->links()}}
    </div><!-- ./col -->
    <div class="col-lg-3"><!-- Nuovi Pagamenti non ancora guardati -->
        <div class="panel panel-success">
            <div class="panel-heading bg-green">
                <b>New Payments</b>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Pay</th>
                    <th style="text-align:right">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php Paginator::setPageName('pnew'); ?>
                @foreach($newPayments as $payment)
                <tr>
                    <td><a href="{{URL::to('admin/payments/'.$payment->id_payment)}}">{{$payment->id_payment}}</a></td>
                    <td>
                        @if($payment->isPaid)
                        <span class="label label-success">Success</span>
                        @else
                        <span class="label label-danger">Error</span>
                        @endif
                    </td>
                    <td align="right">{{ number_format($payment->total,2,',','.') }} €</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$failPayments->appends(['pshippings' => Input::get('pshippings',1)])->links()}}
    </div><!-- ./col -->
 </div>
@stop
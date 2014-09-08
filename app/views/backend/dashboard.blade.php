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
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>
                    {{$data['orderCount']}}
                </h3>
                <p>
                    Orders
                </p>
            </div>
            <div class="icon">
                {{FA::icon('money')}}
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
                    {{$data['ticketCount']}}
                </h3>
                <p>
                    Ticket Selled
                </p>
            </div>
            <div class="icon">
                {{FA::icon('ticket')}}
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>
                    {{number_format($data['total_amount'],0,',','.')}}<sup style="font-size: 20px">€</sup>
                </h3>
                <p>
                    T. Amount
                </p>
            </div>
            <div class="icon">
                {{FA::icon('euro')}}
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>
                    {{count($subscriptions)}}
                </h3>
                <p>
                    Subscribers
                </p>
            </div>
            <div class="icon">
                {{FA::icon('envelope')}}
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
</div>

<div class="row">
    <div class="col-lg-3">
        <div class="panel panel-info">
            <div class="panel-heading bg-aqua">
                <b>Last 10 Payments</b>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php Paginator::setPageName('ppayments'); ?>
                @foreach($payments as $payment)
                    <tr>
                        <td><a href="{{URL::to('admin/payments/'.$payment->id_payment)}}">{{$payment->id_payment}}</a></td>
                        <td><a href="{{URL::to('admin/users/'. $payment->user->id_user)}}">{{$payment->user->firstname}}</a></td>
                        <td>{{ number_format($payment->total,0,',','.') }} €</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$payments->appends(['ptickets' => Input::get('ptickets',1),
                                'psubscribers' => Input::get('psubscribers',1)])->links()}}
    </div><!-- ./col -->
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading bg-green">
                <b>Most Purchased Ticket</b>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>Match</th>
                    <th>Ticket</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                <?php Paginator::setPageName('ptickets'); ?>
                @foreach($tickets as $ticket)
                <tr>
                    <td><a href="{{URL::to('admin/matches/'.$ticket->id_match)}}">{{$ticket->label_match}}</a></td>
                    <td><a href="{{URL::to('admin/tickets/'.$ticket->id_ticket)}}">{{$ticket->label}}</a></td>
                    <td>{{$ticket->qty_selled}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        {{$tickets->appends(
                    ['ppayments' => Input::get('ppayments',1),
                    'psubscribers' => Input::get('psubscribers',1)])->links()}}
    </div><!-- ./col -->
    <div class="col-lg-3">
        <div class="panel panel-warning">
            <div class="panel-heading bg-yellow">
                <b>Total Gain</b>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Match</th>
                    <th>Total-</th>
                </tr>
                </thead>
                <tbody>
                @foreach($totalArray as $singleMatch)

                    <tr>
                        <td>#</td>
                        <td>
                            <a href="{{URL::to('admin/matches/'.$singleMatch->id_match)}}">{{$singleMatch->label_match}}</a>
                        </td>
                        <td>{{number_format($singleMatch->total,2,',','.')}} €</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3">
        <div class="panel panel-danger">
            <div class="panel-heading bg-red">
                <b>Subscription</b>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Match</th>
                    <th>Number</th>
                </tr>
                </thead>
                <tbody>
                <?php Paginator::setPageName('psubscribers'); ?>
                @foreach($subscriptions as $subscription)
                <tr>
                    <td>#</td>
                    <td><a href="{{URL::to('admin/matches/'.$subscription->id_match)}}">{{$subscription->label_match}}</a></td>
                    <td><a href="#">{{$subscription->qty}}</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div><!-- ./col -->
</div>
@stop
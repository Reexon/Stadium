@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop

@section('header-title')
<h1>
    All Payments <a href="{{URL::to('admin/payments/create')}}" class="btn btn-sm btn-primary">{{FA::icon('plus')}}</a>
    <small>Overview</small>
</h1>
@stop
@section('content')

<div class="nav-tabs-custom">
    <!-- Tabs within a box -->
    <ul class="nav nav-tabs pull-right">
        <li class="active"><a href="#success" data-toggle="tab">Success</a></li>
        <li><a href="#failed" data-toggle="tab">Failed</a></li>
        <li><a href="#problem" data-toggle="tab">Problem</a></li>
        <li class="pull-left header"><i class="fa fa-inbox"></i>Payments</li>
    </ul>
    <div class="tab-content no-padding">
        <div class="tab-pane active" id="success">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Buyer</th>
                        <th>Status</th>
                        <th>Pay Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($successPayments as $payment)
                        <tr>
                            <td>
                                <a href="{{URL::to('admin/users/'.$payment->user_id)}}">{{$payment->user->fullname}}</a>
                            </td>
                            <td>{{$payment->status}}</td>
                            <td>{{$payment->pay_date->format('d-m-Y')}}</td>
                            <td>
                                <a href="{{URL::to('admin/payments/'.$payment->id_payment)}}" class="btn btn-success">{{FA::icon('eye')}}</a>
                            @if($payment->hasFootballEvent)
                                <a href="{{URL::to('admin/payments/'.$payment->id_payment.'/consumers')}}" class="btn btn-danger">{{FA::icon('users')}}</a>
                            @endif
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
            {{$successPayments->links()}}
        </div>
        <div class="tab-pane" id="failed">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Buyer</th>
                        <th>Status</th>
                        <th>Pay Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($failedPayments as $payment)
                        <tr>
                            <td>
                                <a href="{{URL::to('admin/users/'.$payment->user_id)}}">{{$payment->user->fullname}}</a>
                            </td>
                            <td>{{$payment->status}}</td>
                            <td>{{$payment->pay_date->format('d-m-Y')}}</td>
                            <td>
                            <a href="{{URL::to('admin/payments/'.$payment->id_payment)}}" class="btn btn-success">{{FA::icon('eye')}}</a>
                            @if($payment->hasFootballEvent)
                                <a href="{{URL::to('admin/payments/'.$payment->id_payment.'/consumers')}}" class="btn btn-danger">{{FA::icon('users')}}</a>
                            @endif
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
            {{$failedPayments->links()}}
        </div>
        <div class="tab-pane" id="problem">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Buyer</th>
                        <th>Status</th>
                        <th>Pay Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($problemPayments as $payment)
                        <tr>
                            <td>
                                <a href="{{URL::to('admin/users/'.$payment->user_id)}}">{{$payment->user->fullname}}</a>
                            </td>
                            <td>{{$payment->status}}</td>
                            <td>{{$payment->pay_date->format('d-m-Y')}}</td>
                            <td>
                            <a href="{{URL::to('admin/payments/'.$payment->id_payment)}}" class="btn btn-success">{{FA::icon('eye')}}</a>
                            @if($payment->hasFootballEvent)
                                <a href="{{URL::to('admin/payments/'.$payment->id_payment.'/consumers')}}" class="btn btn-danger">{{FA::icon('users')}}</a>
                            @endif
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
            {{$problemPayments->links()}}
        </div>
    </div>
</div>
@stop
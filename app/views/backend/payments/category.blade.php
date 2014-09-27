@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop

@section('header-title')
<h1>
    <?php $category = $payments->first()->orders->first()->ticket->category; ?>
    All Payments for {{$category->name}}  <a href="{{URL::to('admin/payments/create/'.$category->id_category)}}" class="btn btn-sm btn-primary">{{FA::icon('plus')}}</a>
    <small>Overview</small>
</h1>
@stop
@section('content')

<table class="table table-striped">
    <thead>
        <tr>
            <th>TrackID</th>

            <th>Status</th>
            <th>Tracking Code</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($payments as $payment)
        <tr>
            <td>{{$payment->trackid}}</td>
            <td>
                @if($payment->status == "APPROVED")
                    <span class="label label-success">Success</span>
                @else
                    <span class="label label-danger">Failed</span>
                @endif
            </td>
            <td>
                @if($payment->trackingcode == NULL)
                    <span class="label label-danger">Not Set</span>
                @else
                    {{$payment->trackingcode}}
                @endif
            </td>
            <td>
                {{number_format($payment->total,2,',','.')}} €
            </td>
            <td>
                <a href="{{URL::to('admin/payments/'.$payment->id_payment)}}" class="btn btn-small btn-success">{{FA::icon('eye')}}</a>
                @if($payment->trackingcode == null)
                <a href="{{URL::to('admin/payments/'.$payment->id_payment.'/trackingCode')}}" class="btn btn-small btn-warning">{{FA::icon('truck')}}</a>
                @else
                <a href="{{URL::to('admin/payments/'.$payment->id_payment.'/trackingCode')}}" class="btn btn-small btn-primary">{{FA::icon('pencil')}}</a>
                @endif
                @if(in_array($category->id_category,Backend\Model\Match::$category))
                <a href="{{URL::to('admin/payments/'.$payment->id_payment.'/consumers')}}" class="btn btn-small btn-danger">{{FA::icon('users')}}</a>
                @endif
            </td>

        </tr>
    @endforeach
    </tbody>
</table>

@stop
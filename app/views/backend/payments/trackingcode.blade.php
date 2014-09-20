@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop

@section('header-title')
<h1>
    Add Tracking Code for {{$payment->trackid}}
   <small>Overview</small>
</h1>
@stop
@section('content')
<div class="row">
    <?php $url = 'admin/payments/'.$payment->id_payment.'/updateTrackingCode'; ?>
    <div class="col-md-4">
        {{Form::model($payment,['url' => $url , 'role' => 'form'])}}
        <div class="box box-warning">

            <div class="box-header">
                <h3 class="box-title">Tracking Code</h3>
            </div>
            <div class="box-body">

                <div class="form-group">
                        {{Form::label('Tracking Code:')}}
                        {{Form::text('trackingcode',Input::old('trackingcode'),['class' => 'form-control','placeholder' => 'Tracking Code'])}}
                </div>
                <div class="form-group">
                    {{Form::label('Send Notification to:')}}<br>
                        @if($payment->email == $payment->user->email)
                            {{Form::checkbox('send_notifications_buyer','yes', true,['class' => 'form-control'])}} Buyer ({{$payment->email}})<br>
                        @else
                            {{Form::checkbox('send_notifications_buyer','yes',true,['class' => 'form-control'])}} Buyer ({{$payment->user->email}})<br>
                            {{Form::checkbox('send_notifications_ship','yes', true,['class' => 'form-control'])}} Shipping ({{$payment->email}})<br>
                        @endif
                </div>

            </div>

            <div class="box-footer">
                <div class="input-group">
                    {{Form::submit('Salva Tracking Code',['class' => 'btn btn-block btn-danger'])}}
                </div>
            </div>
        </div>
        {{Form::close()}}
    </div>

</div>
@stop
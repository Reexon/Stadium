@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop


@section('header-title')
<h1>Payments Details
    <small>#{{$payment->id_payment}}</small>
</h1>
@stop

    @section('content')
<?php $user = $payment->user; ?>

<section class="content invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Stadium Srl.
                <small class="pull-right"><b>Status:</b>
                    @if($payment->status == "APPROVED")
                        <span class="label label-success">Payed</span>
                    @elseif($payment->status =="NOT APPROVED")
                        <span class="label label-warning">Not Payed Yet</span>
                    @else
                        <span class="label label-danger">Payment Error</span>
                    @endif
                </small>
            </h2>
        </div><!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Buyer
            <address>
                <strong>{{$user->firstname}} {{$user->lastname}}</strong><br>
                {{$user->city}}, {{$user->cap}}<br>
                {{$user->address}}<br>
                <b>Phone:</b> {{$user->mobile}}<br>
                <b>Email:</b> {{$user->email}}
            </address>
        </div><!-- /.col -->
        <div class="col-sm-4 invoice-col">
            Shipping to
            <address>
                <strong>{{$payment->firstname}} {{$payment->lastname}}</strong><br>
                {{$payment->city}}, {{$payment->cap}}<br>
                {{$payment->address}}<br>
                <b>Phone:</b> {{$payment->mobile}}<br>
                <b>Email:</b> {{$payment->email}}
            </address>
        </div><!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <br>
            <br>
            <b>Order ID:</b> {{$payment->trackid}}<br>
            <b>Payment Date:</b> {{$payment->pay_date->format('d/m/Y')}}<br>
            <b>Tracking Code:</b>
                <?php echo $payment->trackingcode == null ? "N/A" : $payment->trackingcode; ?><br>
            <b>Signed By:</b>
                <?php echo $payment->signedBy == null ? "N/A" : $payment->signedBy;?>
        </div><!-- /.col -->
    </div><!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Qty</th>
                    <th>Product</th>
                    <th>Serial #</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($payment->orders as $order)
                    <tr>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->ticket->label }}</td>
                        <td>{{ $order->id_order }}</td>
                        <td>{{ $order->quantity * $order->ticket->price }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
            <p class="lead">Payment Methods:</p>
            <img src="../../img/credit/visa.png" alt="Visa">
            <img src="../../img/credit/mastercard.png" alt="Mastercard">
            <img src="../../img/credit/american-express.png" alt="American Express">
            <img src="../../img/credit/paypal2.png" alt="Paypal">
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
            </p>
        </div><!-- /.col -->
        <div class="col-xs-6">
            <p class="lead">Amount Due 2/22/2014</p>
            <div class="table-responsive">
                <table class="table">
                    <tbody><tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>{{number_format($payment->total,2,',','.')}} €</td>
                    </tr>
                    <tr>
                        <th>Tax </th>
                        <td>0 €</td>
                    </tr>
                    <tr>
                        <th>Shipping:</th>
                        <td>0 €</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td>{{number_format($payment->total,2,',','.')}} €</td>
                    </tr>
                    </tbody></table>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
            <button class="btn btn-warning pull-right" data-toggle="modal" data-target="#myModal" >{{FA::icon('barcode')}} Add Tracking Code</button>
            @if($payment->isPaid)
                <a class="btn btn-danger pull-right" style="margin-right: 5px;" href="{{URL::to('admin/payments/'.$payment->id_payment.'/markAsUnpaid')}}">{{FA::icon('credit-card')}} Mark as Unpaid</a>
            @else
                 <a class="btn btn-success pull-right" style="margin-right: 5px;" href="{{URL::to('admin/payments/'.$payment->id_payment.'/markAsPaid')}}">{{FA::icon('credit-card')}} Mark as Paid</a>
            @endif
            @if($payment->hasFootballEvent)
                <a href="{{URL::to('admin/payments/'.$payment->id_payment.'/consumers')}}" class="btn btn-danger pull-right" style="margin-right: 5px;">{{FA::icon('users')}} Consumers</a>
            @endif
            <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Tracking Code</h4>
                </div>
                {{Form::open(['action' => ['Backend\Controller\PaymentsController@updateTrackingCode',$payment->id_payment]])}}
                <div class="modal-body">
                    {{Form::text('trackingcode',Input::old('trackingcode'),['class' => 'form-control','placeholder' => 'Tracking Code'])}}
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{Form::button('Save Tracking Code',['class' => 'btn btn-primary','type'=>'submit'])}}
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
</section>
    @stop
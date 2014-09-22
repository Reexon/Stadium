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
                Phone: {{$user->mobile}}<br>
                Email: {{$user->email}}
            </address>
        </div><!-- /.col -->
        <div class="col-sm-4 invoice-col">
            Shipping to
            <address>
                <strong>{{$payment->firstname}} {{$payment->lastname}}</strong><br>
                {{$payment->city}}, {{$payment->cap}}<br>
                {{$payment->address}}<br>
                Phone: {{$payment->mobile}}<br>
                Email: {{$payment->email}}
            </address>
        </div><!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <br>
            <br>
            <b>Order ID:</b> {{$payment->trackid}}<br>
            <b>Payment Date:</b> {{$payment->pay_date->format('d/m/Y')}}<br>
            <b>Tracking Code:</b>
                <?php echo $payment->trackingcode == null ? "N/A" : $payment->trackingcode; ?>
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
            <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
            <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
        </div>
    </div>
</section>
    @stop
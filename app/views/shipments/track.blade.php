@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop


    @section('header-title')
    <h1>
        Shipments Status
        <small></small>
    </h1>
    @stop

    @section('content')
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Buyer</th>
                    <th>Pay Date</th>
                    <th>Tracking Code</th>
                    <th>Ship Status</th>
                    <th>Signed By</th>
                </tr>
            </thead>
            <tbody>
            @foreach($shipments as $shipment)
            <tr>
                <td>
                    <a href="{{URL::to('admin/payments/'.$shipment->id_payment)}}">{{$shipment->id_payment}}</a>
                </td>
                <td>
                    <a href="{{URL::to('admin/users/'.$shipment->user_id)}}">{{$shipment->user->fullname}}</a>
                </td>
                <td>{{$shipment->pay_date->format('d.m.Y')}}</td>
                <td>
                    <a href="{{Config::get('administrator.UPSTrackingLink')}}{{$shipment->trackingcode}}">{{$shipment->trackingcode}}</a>
                </td>
                <td>
                    <?php $status = $shipment->shipmentStatus;?>
                    @if($status == "DELIVERED")
                        <span class="label label-success">{{$status}}</span>
                    @elseif($status == "In Transit" || $status == "OUT FOR DELIVERY")
                        <span class="label label-warning">{{$status}}</span>
                    @else
                        <span class="label label-danger">{{$status}}</span>
                    @endif
                </td>
                <td>{{$shipment->signedBy}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
{{$shipments->links()}}
    @stop
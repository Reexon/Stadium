@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop


    @section('header-title')
    <h1>
        Payments Waiting
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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $i=0;?>
            @foreach($shipments as $shipment)
            <tr>
                <td>
                    <a href="{{URL::to('admin/payments/'.$shipment->id_payment)}}">{{$shipment->id_payment}}</a>
                </td>
                <td><a href="{{URL::to('admin/users/'.$shipment->user_id)}}">{{$shipment->user->fullname}}</a></td>
                <td>{{$shipment->pay_date->format('d.m.Y')}}</td>
                <td>
                    {{Form::button(FA::icon('truck'),['class' => 'btn btn-warning','data-toggle'=>'modal', 'data-target'=>'#trackModal'.$i])}}
                </td>
            </tr>
        <? $i++; ?>
            @endforeach
        </tbody>
    </table>

{{$shipments->links()}}

@for ($i=0;$i< count($shipments);$i++)
<!-- Genero un modal per ogni shipment in attesa -->
<div class="modal fade" id="trackModal{{$i}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Add Tracking Code (Order #{{$shipments[$i]->id_payment}})</h4>
                <small>{{$shipments[$i]->user->fullname}}</small>
            </div>
            {{Form::open(['action' => ['Backend\Controller\PaymentsController@updateTrackingCode',$shipments[$i]->id_payment]])}}
            <div class="modal-body">
                {{Form::text('trackingcode',Input::old('trackingcode'),['class' => 'form-control','placeholder' => 'Tracking Code'])}}
                <div class="form-group">
                    {{Form::label('Send Notification to:')}}<br>
                    @if($shipments[$i]->email == $shipments[$i]->user->email)
                    {{Form::checkbox('send_notifications_buyer','yes', true,['class' => 'form-control'])}} Buyer ({{$shipments[$i]->email}})<br>
                    @else
                    {{Form::checkbox('send_notifications_buyer','yes',true,['class' => 'form-control'])}} Buyer ({{$shipments[$i]->user->email}})<br>
                    {{Form::checkbox('send_notifications_ship','yes', true,['class' => 'form-control'])}} Shipping ({{$shipments[$i]->email}})<br>
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
@endfor
    @stop
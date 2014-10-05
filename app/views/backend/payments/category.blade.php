@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop

@section('header-title')
<h1>
    <?php $category = $payments->first()->orders->first()->ticket->event->category; ?>
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
    <?php $i=0;?>
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
                    {{Form::button(FA::icon('truck'),['class' => 'btn btn-warning','data-toggle'=>'modal', 'data-target'=>'#trackModal'.$i])}}
                @else
                <a href="{{URL::to('admin/payments/'.$payment->id_payment.'/trackingCode')}}" class="btn btn-small btn-primary">{{FA::icon('pencil')}}</a>
                @endif
                @if(in_array($category->id_category,Backend\Model\Match::$category))
                    <a href="{{URL::to('admin/payments/'.$payment->id_payment.'/consumers')}}" class="btn btn-small btn-danger">{{FA::icon('users')}}</a>
                @endif
            </td>

        </tr>
    <?php $i++;?>
    @endforeach
    </tbody>
</table>


@for ($i=0;$i< count($payments);$i++)
    @if($payment->trackingcode == null)
    <!-- Genero un modal per ogni shipment in attesa -->
    <div class="modal fade" id="trackModal{{$i}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add Tracking Code (Order #{{$payments[$i]->id_payment}})</h4>
                    <small>{{$payments[$i]->user->fullname}}</small>
                </div>
                {{Form::open(['action' => ['Backend\Controller\PaymentsController@updateTrackingCode',$payments[$i]->id_payment]])}}
                <div class="modal-body">
                    {{Form::text('trackingcode',Input::old('trackingcode'),['class' => 'form-control','placeholder' => 'Tracking Code'])}}
                    <div class="form-group">
                        {{Form::label('Send Notification to:')}}<br>
                        @if($payments[$i]->email == $payments[$i]->user->email)
                        {{Form::checkbox('send_notifications_buyer','yes', true,['class' => 'form-control'])}} Buyer ({{$payments[$i]->email}})<br>
                        @else
                        {{Form::checkbox('send_notifications_buyer','yes',true,['class' => 'form-control'])}} Buyer ({{$payments[$i]->user->email}})<br>
                        {{Form::checkbox('send_notifications_ship','yes', true,['class' => 'form-control'])}} Shipping ({{$payments[$i]->email}})<br>
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
    @endif
@endfor
@stop
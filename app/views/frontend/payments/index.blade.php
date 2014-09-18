@extends('layouts.master')

@section('head')
@parent
{{HTML::style('css/bootstrap-star-rating/star-rating.min.css')}}
{{HTML::script('js/bootstrap-star-rating/star-rating.min.js')}}
@stop


@section('navigation')
@parent
@stop


@section('header-title')
<h1>All Your Payments
    <small></small>
</h1>
@stop

@section('content')

@if(is_object($userInfo->payments()))

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($userInfo->payments as $payment)
                <tr>
                    <td>{{$payment->trackid}}</td>
                    <td>{{$payment->pay_date->format('d.m.Y')}}</td>
                    <td>{{number_format($payment->total,2,',','.')}} €</td>
                    <td>
                        <input id="rating"
                               name="rating" class="rating"
                               data-show-clear="false"
                               data-min="0" data-max="5"
                               data-step="1" data-size="xs"
                               data-readonly="true"
                               value="{{$payment->feedback->rating}}">
                    </td>

                    <td>
                        @if($payment->status == "APPROVED")
                            <span class="label label-success">Success</span>
                        @else
                            <span class="label label-danger">Problem</span>
                        @endif
                    </td>
                    <td>
                        @if($payment->trackingcode == NULL)
                            <span class="label label-danger">Not Shipped</span>
                        @else
                            {{$payment->trackingcode}}
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-small btn-success" href="{{ URL::to('user/payments/' . $payment->id_payment) }}" data-toggle="tooltip" data-original-title="Show Details">{{ FA::icon('eye')}}</a>
                        <a class="btn btn-small btn-warning" href="{{ URL::to('feedbacks/create/' . $payment->feedback->uuid) }}" data-toggle="tooltip" data-original-title="Feedback">{{ FA::icon('star')}}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
<!--Inizializzo le label del rating -->
<script>
    $('input[name="rating"]').rating({
        starCaptions: {1: "Very Poor", 2: "Poor", 3: "Not Bad", 4: "Good", 5: "Amazing !"}
    })
</script>

@else
    <h2>you've no payment !</h2>
@endif

@stop
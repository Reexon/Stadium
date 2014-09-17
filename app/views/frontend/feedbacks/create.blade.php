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
    <h1>Display All Matches
        <small></small>
    </h1>
@stop

@section('content')
<section id="feedback-form">
    <h2 class="page-header">Send Feedback - {{$feedback->uuid}}</h2>
    <div class="row">
        <div class="col-md-3">
            <p>Please fill this form and let us know how was your experience with us!</p>
        </div>

        {{Form::model($feedback,['url' => 'feedbacks'])}}
        {{Form::hidden('id_feedback',$feedback->id_feedback)}}
        <div class="col-md-5 col-sm-8">
            <div class="well">
                {{$feedback->payment->user->firstname}} {{$feedback->payment->user->lastname}}
            </div>
            <p>Ratings !</p>
            <div class="well">
                @if($feedback->comment == null || $feedback->rating == null)
                    <input id="rating"
                           name="rating" class="rating"
                           data-show-clear="false"
                           data-min="0" data-max="5"
                           data-step="1" data-size="xs">
                @else
                    <input id="rating"
                           name="rating" class="rating"
                           data-show-clear="false"
                           data-min="0" data-max="5"
                           data-step="1" data-size="xs"
                           data-readonly="true"
                           value="{{$feedback->rating}}">
                @endif
                <!--Inizializzo le label del rating -->
                <script>
                    $('#rating').rating({
                        starCaptions: {1: "Very Poor", 2: "Poor", 3: "Not Bad", 4: "Good", 5: "Amazing !"}
                    })
                </script>
            </div>
            <p>
                Purchased Tickets
            </p>
            <div class="well">
                @foreach($feedback->payment->orders as $order)
                    @if($order->ticket->event->category_id == 1)
                        <p>{{$order->ticket->match->homeTeam->name}} vs {{$order->ticket->match->guestTeam->name}} ({{$order->ticket->label}}x{{$order->quantity}})</p>
                    @else
                        <p>{{$order->ticket->concert->artist->name}} - {{$order->ticket->label}}x{{$order->quantity}}</p>
                    @endif
                @endforeach
            </div>
            @if(($feedback->comment == null) || empty($feedback->comment) )
                <div class="well">
                        {{Form::textarea('comment',Input::old('comment'),['class'=>'form-control'])}}
                </div>
                {{Form::submit('Send Feedback',['class' => 'btn btn-primary'])}}
            @else
            <p>
                Your Comment:
            </p>
            <div class="well">
                {{ $feedback->comment}}
            </div>
            @endif
        </div>
        {{Form::close()}}
    </div>
</section>
@stop
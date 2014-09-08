@extends('layouts.master')

@section('head')
    @parent
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
                <span class="rating">
                  <span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span>
                </span>
            </div>
            <p>
                Purchased Tickets
            </p>
            <div class="well">
                @foreach($feedback->payment->orders as $order)
                    {{$order->ticket->match->homeTeam->name}} vs {{$order->ticket->match->guestTeam->name}} - {{$order->ticket->label}}x{{$order->quantity}}
                @endforeach
            </div>
            @if(($feedback->comment == null) || empty($feedback->comment) )
                <div class="well">
                        {{Form::textarea('comment',Input::old('comment'),['class'=>'form-control'])}}
                </div>
                {{Form::submit('Send Rating',['class' => 'btn btn-primary'])}}
            @endif
        </div>
        {{Form::close()}}
    </div>
</section>
@stop
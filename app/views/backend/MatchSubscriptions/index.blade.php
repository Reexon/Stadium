@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop


    @section('header-title')
    <h1>
        All Subscribers
        <small></small>
    </h1>
    @stop

    @section('content')

    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">All Match Subscribers</div>
        <div class="panel-body">
            <p>From here you can view all subscribers of all match</p>
        </div>

        <!-- Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Match</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($subscriptions as $subscription)
                <tr>
                    <td>{{$subscription->id_subscription}}</td>
                    <td>{{$subscription->email}}</td>
                    <td><a href="{{URL::to('admin/matches/'.$subscription->id_match)}}">{{$subscription->label_match}}</a></td>
                    <td>
                        {{Form::open(['url' => 'admin/MatchSubscriptions/'.$subscription->id_subscription,'method' =>'DELETE'])}}
                        {{Form::button(FA::icon('trash-o'), array('type' => 'submit', 'class' => 'btn btn-small btn-danger'))}}
                        {{Form::close()}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$subscriptions->links()}}
    </div>

    @stop
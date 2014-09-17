@extends('layouts.master')

@section('head')
@parent
@stop

@section('navigation')
@parent
@stop

@section('header-title')
<h1>
    <?php $category = $payments->first()->orders->first()->ticket->category; ?>
    All Payments for {{$category->name}}  <a href="{{URL::to('admin/payments/create/'.$category->id_category)}}" class="btn btn-sm btn-primary">{{FA::icon('plus')}}</a>
    <small>Overview</small>
</h1>
@stop
@section('content')

@stop
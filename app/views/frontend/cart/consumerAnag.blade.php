@extends('layouts.master')

@section('head')
@parent
{{HTML::style('css/ProgressTracker.css')}}
@stop


@section('navigation')
@parent
@stop

@section('header-title')
<h1>Fill all forms field
    <small></small>
</h1>
@stop

@section('content')
<p class="lead">

    Abbiamo rilevato che stai cercando di acquistare dei biglietti per partite di calcio Italiane.<br>
    E' obbligatorio che tu compili i moduli sottostanti, inserendo <b>i dati di chi utilizzerà il biglietto.</b><br>
</p>
<div class="alert alert-warning">
    {{FA::icon('warning')}}
    Fai Attenzione a inserire i dati correttamente !
</div>
{{Form::open(['url' => 'cart/consumerInfo','class' =>'form-horizontal'])}}
@for($i = 0; $i<$total_ticket; $i++)
    @if(($i)%3 ==0)
        <div class="row">
    @endif
        <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Final Consumer #{{$i+1}}</h3>
            </div>
            <div class="box-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label">Ticket</label>
                    <div class="col-sm-8">
                        {{Form::select('consumer[ticket_id][]',$selectOptionTickets ,null,['class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">Born Date</label>
                    <div class="col-sm-8">
                        {{Form::text('consumer[born_date][]',null,['class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">Born Location</label>
                    <div class="col-sm-8">
                        {{Form::text('consumer[born_location][]',null,['class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">Via Residenza</label>
                    <div class="col-sm-8">
                        {{Form::text('consumer[res_via][]',null,['class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">CAP Residenza</label>
                    <div class="col-sm-8">
                        {{Form::text('consumer[res_cap][]',null,['class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">Comune Residenza</label>
                    <div class="col-sm-8">
                        {{Form::text('consumer[res_com][]',null,['class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">Prov Residenza</label>
                    <div class="col-sm-8">
                        {{Form::text('consumer[res_prov][]',null,['class' => 'form-control'])}}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">CF</label>
                    <div class="col-sm-8">
                        {{Form::text('consumer[cf][]',null,['class' => 'form-control'])}}
                    </div>
                </div>

            </div>
        </div>
    </div>
            @if(($i+1)%3 ==0)
            </div>
                @endif
    @endfor

<div class="row">
    <div class="col-md-10">
        {{Form::button('Proceed with Checkout',['class' => 'btn btn-danger btn-block','type' => 'submit'])}}
    </div>
</div>
{{Form::close()}}


@stop
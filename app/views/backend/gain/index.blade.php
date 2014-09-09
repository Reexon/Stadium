@extends('layouts.master')

@section('head')
@parent
<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.5.1.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.5.1.min.js"></script>

@stop


@section('navigation')
@parent
@stop


@section('content')
<div class="box box-primary">
    <div class="box-header">
        <div class="box-title">
             {{FA::icon('euro')}} Total Gain Each Month
        </div>
    </div>
    <div id="monthGainChart" style="height: 300px;"></div>
</div>

<div class="box box-primary">
    <div class="box-header">
        <div class="box-title">
            {{FA::icon('euro')}} Total Gain Each Years
        </div>
    </div>
    <div id="yearGainChart" style="height: 300px;"></div>
</div>

<script>


    new Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'monthGainChart',

        data: [
            <?php foreach($monthGain as $record)
             echo "{ month: '$record->month', gain: $record->total },"
             ?>
        ],
        xkey: 'month',
        ykeys: ['gain'],
        labels: ['Gain']
    });

    new Morris.Bar({
        // ID of the element in which to draw the chart.
        element: 'yearGainChart',

        data: [
            <?php foreach($yearGain as $record)
             echo "{ year: '$record->year', gain: $record->total },"
             ?>
        ],
        xkey: 'year',
        ykeys: ['gain'],
        labels: ['Gain']
    });
</script>
@stop
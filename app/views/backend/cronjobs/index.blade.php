@extends('layouts.master')

    @section('head')
        @parent
    @stop


    @section('navigation')
        @parent
    @stop


    @section('header-title')
    <h1>
        Cron Job History
        <small></small>
    </h1>
    @stop

    @section('content')
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Job Name</th>
                    <th>Status</th>
                    <th>Execution</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cronjobs as $job)
                    @foreach($job->histories as $history)
                        <tr>
                            <td>{{$job->name}}</td>
                            <td>{{$history->result}}</td>
                            <td>{{$history->last_execution->format('d.m.Y H:i:s')}}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

    @stop
<!DOCTYPE html>
<html>
<head>
    <title>{{ $match->home_team }} vs {{ $match->guest_team }}</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

    <!-- da globalizzare -->
    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('matches') }}">Nerd Alert</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('matches') }}">View All Nerds</a></li>
            <li><a href="{{ URL::to('matches/create') }}">Create a Nerd</a>
        </ul>
    </nav>
    <!-- da globalizzare -->

    <h1>Showing {{ $match->home_team }} vs {{ $match->guest_team }}</h1>

    <div class="jumbotron text-center">
        <h2>{{ $match->home_team }} vs {{ $match->guest_team }}</h2>
        <p>
            <strong>Date:</strong> {{ $match->date }}<br>
            <strong>Ticket:</strong>
        </p>
    </div>

</div>
</body>
</html>
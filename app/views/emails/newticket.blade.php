<?php $match = unserialize($match); ?>

New Ticket Are avvailable for match <b>{{$match->homeTeam->name}} vs {{$match->guestTeam->name}}</b> ({{$match->date->format('d.m.Y')}})
<br/>
<a href="{{ URL::to('match/info/'.$match->id_match) }}">You can show and buy the ticket directly from here</a>
<br/>
<br/>

This email was sent to you, because you've subscribed to current match.<br/>
Stadium Srl.
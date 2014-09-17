<?php
$payment = unserialize($payment);
$user = unserialize($user);
$feedback = unserialize($feedback);
?>
Hi {{$user->firstname}} {{$user->lastname}},<br>

@if($payment->status == "APPROVED")

    Thank You for purchase ticket from Stadium !<br>

    You can anytime see your order overview ,login in, and go to "Menu -> My Payments".<br><br>

    Please, after you've received the tickets, <a href="{{URL::to('feedbacks/create/'.$feedback->uuid )}}">leave us a feedback</a>.<br>

@else

    During your payment we've encountered some problem.<br>

    Please contact the administrator at <a href="mailto:info@stadium.it">info@stadium.it</a><br>

    Your Payment status is : {{$payment->status}} <br>

    Your Payment Trackid is : {{$payment->trackid}} <br>

@endif

<?php
$payment = unserialize($payment);
$user = unserialize($user);
$feedback = unserialize($feedback);
?>

Hi {{$user->firstname}} {{$user->lastname}},
Thank You for purchase ticket from Stadium !

You can anytime see your order login in, and go to "Menu -> My Payments".

Please, after you've received the tickets, <a href="{{URL::to('feedbacks/create/'.$feedback->uuid )}}">leave us a feedback</a>.
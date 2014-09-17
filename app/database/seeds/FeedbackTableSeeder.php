<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Backend\Model\Feedback;
use Backend\Model\Payment;
use Backend\Model\Order;
use Backend\Model\Ticket;
class FeedbackTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();


		foreach(range(1, 100) as $index)
		{
            $total = 0;
            foreach(range(1,4) as $boh){//3 order ogni payment
                $qty_ticket = $faker->numberBetween($min = 1,$max=100);

                Order::create([
                    'quantity' => $qty_ticket,
                    'ticket_id' => $faker->numberBetween($min = 1,$max= Ticket::all()->count()),
                    'payment_id' => $index
               ]);

                //calcolo il totale
                $ticket = Ticket::find($index);
                $total += $ticket->quantity * $qty_ticket;
            }


            Payment::create([
                'total'     =>$total,
                'pay_date'  => $faker->unixTime,
                'user_id'   => $faker->numberBetween($min = 1,$max=100),
                'feedback_id'=> $index,
                'trackid'   =>'STDRX'.$faker->unique()->unixTime,
                'status'    => 'APPROVED'
            ]);

            //creo feedback per il payment
			Feedback::create([
                'comment'   => $faker->text(),
                'rating'    =>  $faker->numberBetween($min = 1, $max = 5),
                'uuid'      =>  $faker->uuid
			]);
		}
	}

}
<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Backend\Model\Feedback;
use Backend\Model\Payment;
use Backend\Model\Order;
class FeedbackTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();


		foreach(range(1, 100) as $index)
		{
            foreach(range(1,4) as $boh){//3 order ogni payment
                Order::create([
                    'quantity' => $faker->numberBetween($min = 1,$max=100),
                    'ticket_id' => $faker->numberBetween($min = 1,$max= 30),
                    'payment_id' => $index
               ]);
            }


            Payment::create([
                'total'     =>'',
                'pay_date'  => $faker->unixTime,
                'user_id'   => $faker->numberBetween($min = 1,$max=100),
                'feedback_id'=> $index
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
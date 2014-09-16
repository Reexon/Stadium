<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Backend\Model\MatchSubscription;
class SubscriptionTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 31) as $index)//loop eventi
		{
            foreach(range(1,10) as $boh){//per ogni evento 10 subscription
                MatchSubscription::create([
                    'email'     => $faker->email,
                    'event_id'  => $index,
                    'subscription_date' => $faker->unixTime
                ]);
            }
		}
	}

}
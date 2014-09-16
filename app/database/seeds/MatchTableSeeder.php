<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Backend\Model\Match;

class MatchTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 20) as $index)
		{
			Match::create([
                'home_id'   => $index,
                'guest_id'  => ($index+1),
                'date'      => $faker->unixTime,
                'stadium'   => $faker->city,
                'category_id'=> 1
			]);
		}
	}

}
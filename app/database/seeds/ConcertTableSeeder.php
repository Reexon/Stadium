<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Backend\Model\Concert;

class ConcertTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(22, 31) as $index)
		{
			Concert::create([
                'home_id'   => $index,
                'date'      => $faker->unixTime,
                'stadium'   => $faker->city,
                'category_id'=> 2
			]);
		}
	}

}
<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Backend\Model\Ticket;

class TicketTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 30) as $index)//per ogni evento
		{
            /*if($index < 21)//20 eventi calcio
                $cat_id = 1;
            else            //9 eventi concerti
                $cat_id = 2;*/

            foreach(range(1,4) as $boh){//creo 3 ticket
                Ticket::create([
                    'label'     => $faker->company,
                    'price'     => $faker->randomFloat($min = 20 ,$max = 300),
                    'event_id'  => $index,
                    'quantity'  => $faker->numberBetween($min = 1, $max = 100)
                ]);
            }
		}
	}

}
<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Backend\Model\Artist;
use Backend\Model\Concert;
class ArtistTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        $artists = [
            'Emma Marrone',
            'Andrea Bocelli',
            'Eminem',
            'Club Dogo',
            'Rihanna',
            'Coldplay',
            'Beky G',
            'Sia',
            'Eros Ramazzotti',
            'Gigi D\'alessio'
        ];
		foreach($artists as $artist)
		{
			Artist::create([
                'name'          => $artist,
                'category_id'   => Concert::$concert
			]);
		}
	}

}
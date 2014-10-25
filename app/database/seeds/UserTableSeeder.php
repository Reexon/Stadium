<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Backend\Model\User;

class UserTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();


        User::create([
            'firstname' => 'Loris',
            'lastname'  => 'D\'antonio',
            'birth_date'=> $faker->unixTime,
            'mobile'    => $faker->unique()->phoneNumber,
            'email'     => 'loris@reexon.net',
            'city'      => $faker->city,
            'alt_mobile'=> $faker->phoneNumber,
            'address'   => $faker->address,
            'cap'       => $faker->postcode,
            'password'  => Hash::make('123456'),
        ]);

        //DB::statement('ALTER TABLE users AUTO_INCREMENT = 2');
		foreach(range(1, 100) as $index)
		{
			User::create([
                'firstname' => str_replace('.', '', $faker->unique()->firstName),
                'lastname'  => str_replace('.', '', $faker->unique()->lastName),
                'birth_date'=> $faker->unixTime,
                'mobile'    => $faker->unique()->phoneNumber,
                'email'     => $faker->unique()->email,
                'city'      => $faker->city,
                'alt_mobile'=> $faker->phoneNumber,
                'address'   => $faker->address,
                'cap'       => $faker->postcode,
                'password'  => '123456',
                'password_confirmation' => '123456'
			]);
	}

}
}
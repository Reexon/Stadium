<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        DB::table('orders')->truncate();
        DB::table('tickets')->truncate();
        DB::table('events')->truncate();
        DB::table('categories')->truncate();
        DB::table('teams')->truncate();
        DB::table('event_subscriptions')->truncate();
        DB::table('feedbacks')->truncate();
        DB::table('payments')->truncate();


        $this->call('UserTableSeeder');

        $this->call('TeamTableSeeder');
        $this->call('ArtistTableSeeder');
        $this->call('CategoryTableSeeder');
        $this->call('MatchTableSeeder');
        $this->call('ConcertTableSeeder');
        $this->call('SubscriptionTableSeeder');
        $this->call('TicketTableSeeder');
        $this->call('FeedbackTableSeeder');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // disable foreign key constraints

	}

}

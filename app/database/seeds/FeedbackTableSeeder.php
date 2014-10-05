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
                $qty_ticket = $faker->numberBetween($min = 1,$max=10);
                $id_ticket = $faker->numberBetween($min = 1,$max= Ticket::all()->count());
                $order = Order::create([
                    'quantity' => $qty_ticket,
                    'ticket_id' => $id_ticket,
                    'payment_id' => $index
               ]);

                //se il ticket appartiene a una partita di calcio, allora creo dei consumer da associare
                $temp_ticket = Ticket::find($id_ticket);
                if(in_array($temp_ticket->match->category_id,\Backend\Model\Match::$category)){
                    $consumers= [];
                    foreach(range(1,$qty_ticket) as $bah)
                        $consumers[] = new \Backend\Model\Consumer([
                            'firstname' =>  $faker->firstName,
                            'lastname'  =>  $faker->lastName,
                            'res_via'   =>  $faker->address,
                            'res_cap'   =>  $faker->postcode,
                            'res_com'   =>  $faker->city,
                            'res_prov'  =>  $faker->citySuffix,
                            'born_date' =>  $faker->date(),
                            'born_location' =>$faker->address
                        ]);

                    $order->consumers()->saveMany($consumers);
                }

                //calcolo il totale
                $ticket = Ticket::find($index);
                $total += $ticket->quantity * $qty_ticket;
            }

            if($faker->boolean()){
                $status = "APPROVED";
            }else
                $status = "NOT APPROVED";

            Payment::create([
                'total'     =>$total,
                'pay_date'  => $faker->unixTime,
                'user_id'   => $faker->numberBetween($min = 1,$max=100),
                'feedback_id'=> $index,
                'trackid'   =>'STDRX'.$faker->unique()->unixTime,
                'status'    => $status,
                 //Informazioni per la spedizione
                'firstname' => $faker->firstName,
                'lastname'  => $faker->lastName,
                'city'      => $faker->city,
                'address'   => $faker->address,
                'cap'       => $faker->postcode,
                'email'     => $faker->email,
                'mobile'    => $faker->phoneNumber,
                'visited'   => $faker->boolean()
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
<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Backend\Model\Team;

class TeamTableSeeder extends Seeder {

    public function run()
    {

        $teams = [
            'Milan',        'Atalanta',
            'Inter',        'Bologna',
            'Juventus',     'Torino',
            'Parma',        'Udinese',
            'Lecce',        'Cagliari',
            'Livorno',      'Palermo',
            'Barcellona',   'Sampdoria',
            'Real Madrid',  'Parma',
            'Liverpool',    'Lazio',
            'Napoli',       'Roma',
            'Empoli',       'Fiorentina',
        ];

        foreach($teams as $team)
        {
            Team::create([
                'name'  => $team
            ]);
        }
    }

}
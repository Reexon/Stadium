<?php

class Match extends Eloquent {

	// Add your validation rules here
	public static $rules = [
		   'home_team' => 'required',
           'guest_team' => 'required',
           'date'  => 'required|date_format:d-m-Y',
           'stadium'   => 'required'
	];

    protected $primaryKey = 'id_match';

	// Don't forget to fill this array
	protected $fillable = ['home_team','guest_team','date','stadium'];

    public function tickets()
    {
        return $this->hasMany('Ticket');
    }

    protected $attributes = [
        'id_match',
        'home_team',
        'guest_team',
        'date',
        'stadium',
    ];

    //protected $dates = ['date'];
}
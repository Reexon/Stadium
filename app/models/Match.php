<?php

class Match extends Eloquent {

	// Add your validation rules here
	public static $rules = [
		   'home_team' => 'required',
           'guest_team' => 'required'
	];

    protected $primaryKey = 'id_match';

	// Don't forget to fill this array
	protected $fillable = ['home_team','guest_team'];

    public function tickets()
    {
        return $this->hasMany('Ticket');
    }

}
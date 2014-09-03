<?php
namespace Backend\Model;



class Match extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		   'home_team' => 'required',
           'guest_team' => 'required',
           'date'  => 'required',
           'stadium'   => 'required'
	];

    protected $primaryKey = 'id_match';

	// Don't forget to fill this array
	protected $fillable = ['home_team','guest_team','date','stadium'];

    public function tickets()
    {
        return $this->hasMany('Backend\Model\Ticket');
    }

    public function subscribers(){
        return $this->hasMany('Frontend\Model\MatchSubscription');
    }

    protected $dates = ['date'];
}
<?php
namespace Backend\Model;



class Match extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		   'home_id' => 'required',
           'guest_id' => 'required',
           'date'  => 'required',
           'stadium'   => 'required'
	];

    protected $perPage = 10;

    protected $primaryKey = 'id_match';

	// Don't forget to fill this array
	protected $fillable = ['home_id','guest_id','date','stadium'];

    public function tickets()
    {
        return $this->hasMany('Backend\Model\Ticket');
    }

    public function subscribers(){
        return $this->hasMany('Frontend\Model\MatchSubscription');
    }

    public function homeTeam(){

        return $this->belongsTo('Backend\Model\Team','home_id');

    }
    public function guestTeam(){
        return $this->belongsTo('Backend\Model\Team','guest_id');
    }

    protected $dates = ['date'];
}
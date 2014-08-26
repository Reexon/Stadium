<?php

class Ticket extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'label' => 'required',
         'price' => 'required',
         'match_id' => 'required'
	];

    protected $primaryKey = 'id_ticket';

	// Don't forget to fill this array
	protected $fillable = ['label','price','match_id'];

    public function match(){
        return $this->belongsTo('Match');
    }

}
<?php

class Order extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['quantity'];

    protected $primaryKey = 'id_order';

    public function ticket(){
        return $this->belongsTo('Ticket');
    }

    public function payment(){
        return $this->belongsTo('Payment');
    }

}
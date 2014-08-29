<?php

class Payment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
         'total' => 'required'
	];

    protected $primaryKey = 'id_payment';

	// Don't forget to fill this array
	protected $fillable = ['pay_date','total'];

    //campi in formato data
    protected $dates = ['pay_date'];


    public function orders(){
        return Payment::hasMany('Order');
    }

    public function user(){
        return Payment::belongsTo('User');
    }
}
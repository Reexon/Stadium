<?php
namespace Backend\Model;

class Order extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
	    'quantity' => 'required',
        'ticket_id'=> 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['quantity'];
    protected $perPage = 10;
    protected $primaryKey = 'id_order';

    public function ticket(){
        return $this->belongsTo('Backend\Model\Ticket');
    }

    public function payment(){
        return $this->belongsTo('Backend\Model\Payment');
    }

    public function consumers(){
        return $this->hasMany('Backend\Model\Consumer');
    }
}
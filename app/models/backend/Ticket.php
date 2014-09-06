<?php
namespace Backend\Model;

class Ticket extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'label' => 'required',
         'price' => 'required',
         'match_id' => 'required',
         'quantity' => 'required'
	];

    protected $perPage = 10;

    protected $primaryKey = 'id_ticket';

	// Don't forget to fill this array
	protected $fillable = ['label','price','match_id','quantity'];

    public function match(){
        return $this->belongsTo('Backend\Model\Match');
    }
    public function orders(){
        return $this->hasMany('Backend\Model\Order');
    }

}
<?php
namespace Backend\Model;

class Ticket extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'label'        => 'required',
         'price'        => 'required',
         'event_id'     => 'required',
         'quantity'     => 'required',
         'category_id'  =>'required'
	];

    protected $perPage = 10;

    protected $primaryKey = 'id_ticket';

	// Don't forget to fill this array
	protected $fillable = ['label','price','event_id','quantity','category_id'];

    public function match(){
        return $this->belongsTo('Backend\Model\Match','event_id');
    }

    public function event(){
        return $this->belongsTo('Backend\Model\Event','event_id');
    }

    public function concert(){
        return $this->belongsTo('Backend\Model\Concert','event_id');
    }

    public function orders(){
        return $this->hasMany('Backend\Model\Order');
    }

}
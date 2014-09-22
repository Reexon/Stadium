<?php
namespace Backend\Model;

class Payment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
         'total' => 'required',
         'pay_date' => 'required|date'
	];

    public static $rules_update = [
        'pay_date' => 'required|date'
    ];

    protected $primaryKey = 'id_payment';

	// Don't forget to fill this array
	protected $fillable = ['pay_date','total','trackid','status','trackingcode','firstname','lastname','city','cap','address','email','mobile'];

    //campi in formato data
    protected $dates = ['pay_date'];

    protected $perPage = 10;

    public function orders(){
        return Payment::hasMany('Backend\Model\Order');
    }

    public function user(){
        return Payment::belongsTo('Backend\Model\User');
    }

    public function feedback(){
        return $this->belongsTo('Backend\Model\Feedback');
    }
}
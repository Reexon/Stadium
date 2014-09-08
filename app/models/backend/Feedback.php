<?php
namespace Backend\Model;

class Feedback extends \Eloquent {
	protected $fillable = ['uuid'];

    protected $primaryKey = 'id_feedback';

    public function payment(){
        return $this->hasOne('Backend\Model\Payment');
    }
}
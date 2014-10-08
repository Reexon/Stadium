<?php
namespace Backend\Model;

class Cronjob extends \Eloquent {

	protected $fillable = ['name','description'];

    public $timestamps = false;

    protected $primaryKey = 'id_cronjob';

    public function histories(){
        return $this->hasMany('Backend\Model\JobHistory');
    }
}

<?php
namespace Backend\Model;

class JobHistory extends \Eloquent {

	protected $fillable = ['result'];

    protected $table = 'job_history';

    protected $primaryKey = 'cronjob_id';

    protected $dates = ['last_execution'];

    public $timestamps = false;

    public function cronjob(){
        return $this->hasOne('Backend\Model\Cronjob');
    }
}

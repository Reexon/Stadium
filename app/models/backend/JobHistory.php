<?php
namespace Backend\Model;

class JobHistory extends \Eloquent {

	protected $fillable = ['result'];

    protected $table = 'job_history';

    protected $primaryKey = 'id_history';

    protected $dates = ['last_execution'];

    public $timestamps = false;

    public function cronjob(){
        return $this->belongsTo('Backend\Model\Cronjob');
    }
}

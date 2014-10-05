<?php

namespace Backend\Model;


class Event extends \Eloquent{

    protected $table = 'events';

    protected $primaryKey = 'id_event';

    protected $perPage = 10;

    protected $dates = ['date'];

    public function tickets()
    {
        return $this->hasMany('Backend\Model\Ticket','event_id');
    }

    public function subscribers(){
        return $this->hasMany('Frontend\Model\MatchSubscription','event_id');
    }

    public function category(){
        return $this->belongsTo('Backend\Model\Category');
    }

    public function subcategory(){
        return $this->belongsTo('Backend\Model\SubCategory');
    }

} 
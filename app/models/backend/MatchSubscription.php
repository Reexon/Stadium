<?php
namespace Backend\Model;

class MatchSubscription extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'email' => 'required|email|unique:match_subscriptions',
        'match_id' => 'required'

    ];

    protected $primaryKey = 'id_subscription';

    protected $table = 'match_subscriptions';

    protected $dates = ['subscription_date'];

    protected $fillable = ['match_id','email'];

    public function match()
    {
        return $this->belongsTo('Backend\Model\Match');
    }
}
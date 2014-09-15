<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 02/09/14
 * Time: 23:30
 */

namespace Frontend\Model;


class MatchSubscription extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'email' => 'required|email|unique:event_subscriptions'

    ];

    protected $primaryKey = 'id_subscription';

    protected $table = 'event_subscriptions';

    protected $dates = ['subscription_date'];

    protected $fillable = ['event_id','email'];

    public function match()
    {
        return $this->belongsTo('Backend\Model\Match');
    }

} 
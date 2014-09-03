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
        'email' => 'required|email|unique:match_subscriptions'

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
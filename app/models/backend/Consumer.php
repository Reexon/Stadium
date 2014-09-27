<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 24/09/14
 * Time: 23:11
 */

namespace Backend\Model;

class Consumer extends \Eloquent{
    // Add your validation rules here
    public static $rules = [
        'firstname'     => 'required',
        'lastname'      => 'required',
        'res_via'       => 'required',
        'res_cap'       => 'required',
        'res_com'       => 'required',
        'res_prov'      => 'required',
        'born_date'     => 'required',
        'born_location' => 'required'
    ];

    protected $primaryKey = 'id_consumer';

    protected $dates = ['born_date'];

    // Don't forget to fill this array
    protected $fillable = ['firstname','lastname','res_via','res_cap','res_com','res_prov','born_date','born_location'];

    public function order(){
        return $this->belongsTo('Backend\Model\Order');
    }

    public function getFullnameAttribute(){
        return $this->firstname." ".$this->lastname;
    }
} 
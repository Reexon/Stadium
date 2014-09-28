<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 13/09/14
 * Time: 19:04
 */

namespace Backend\Model;


class SubCategory extends \Eloquent{

    protected $rules = [
        'name'  => 'required'
    ];

    protected $table = 'sub_categories';

    protected $fillable = ['name'];

    protected $primaryKey = 'id_subcategory';

    public $timestamps = false;

    public function category(){
        return $this->belongsTo('Backend\Model\Category');
    }

    public function matches(){
        return $this->hasMany('Backend\Model\Match');
    }
} 
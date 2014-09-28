<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 13/09/14
 * Time: 19:04
 */

namespace Backend\Model;


class Category extends \Eloquent{

    protected $rules = [
                'name'  => 'required'
    ];

    protected $fillable = ['name'];

    protected $primaryKey = 'id_category';

    public $timestamps = false;

    public function subcategories(){
        return $this->hasMany('Backend\Model\SubCategory');
    }
} 
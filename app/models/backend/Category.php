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

    public function events(){
        return $this->hasMany('Backend\Model\Event');
    }

    public function scopeConcert($query){
        return $query->whereIn('id_category',Concert::$category);
    }

    public function scopeRace($query){
        return $query->whereIn('id_category',Race::$category);
    }

    public function scopeMatch($query){
        return $query->whereIn('id_category',Match::$category);
    }

} 
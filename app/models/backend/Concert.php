<?php
namespace Backend\Model;

class Concert extends Event {


    public static $category = [5,6];

    public static $concert = 5;

	// Add your validation rules here
	public static $rules = [
		'home_id'       =>'required',
        'date'          =>'required',
        'stadium'       =>'required',
        'category_id'   =>'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['home_id','date','stadium','city','category_id'];

    public function artist(){
        return $this->belongsTo('Backend\Model\Artist','home_id');
    }

    public static function all($columns = array('*'))
    {
        $instance = new static;

        return $instance->newQuery()
            ->where('category_id','=',self::$category)
            ->get($columns);
    }
}
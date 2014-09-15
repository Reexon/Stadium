<?php
namespace Backend\Model;

class Artist extends \Eloquent {

    protected $table = 'teams';

    protected $primaryKey = 'id_team';

	// Add your validation rules here
	public static $rules = [
		 'name' => 'required',
        'category_id' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['name','category_id'];

    public function concerts(){
        return $this->hasMany('Backend\Model\Concert','home_id');
    }

    public static function all($columns = array('*'))
    {
        $instance = new static;

        return $instance->newQuery()
            ->where('category_id','=',Concert::$concert)
            ->get($columns);
    }
}
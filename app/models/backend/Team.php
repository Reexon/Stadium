<?php
namespace Backend\Model;

class Team extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'name' => 'required'
	];

    protected $perPage = 10;

	// Don't forget to fill this array
	protected $fillable = ['name'];

    protected $table = 'teams';

    protected $primaryKey = 'id_team';

    public function matchesHome(){
        return $this->hasMany('Backend\Model\Match','home_id');

    }
    public function matchesGuest(){
        return $this->hasMany('Backend\Model\Match','guest_id');

    }
}
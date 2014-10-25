<?php
namespace Backend\Model;

class Match extends Event {

	// Add your validation rules here
	public static $rules = [
		   'home_id'        => 'required',
           'guest_id'       => 'required',
           'date'           => 'required',
           'stadium'        => 'required',
           'category_id'    => 'required',
           'subcategory_id'=> 'required'
	];


    //viene inserito array per poter gestire diverse categorie (hockey,rugby,nba ecc)
    public static $category = [1,2,3,4];

    public static $football = 1;

	// Don't forget to fill this array
	protected $fillable = ['home_id','guest_id','date','stadium','category_id','subcategory_id'];

    public function homeTeam(){
        return $this->belongsTo('Backend\Model\Team','home_id');
    }

    public function guestTeam(){
        return $this->belongsTo('Backend\Model\Team','guest_id');
    }


}
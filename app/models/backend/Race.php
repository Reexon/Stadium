<?php
namespace Backend\Model;

class Race extends Event {

	// Add your validation rules here
	public static $rules = [
           'date'           => 'required',
           'stadium'        => 'required',
           'category_id'    => 'required',
           'subcategory_id' => 'required'
	];


    //viene inserito array per poter gestire diverse categorie (hockey,rugby,nba ecc)
    public static $category = [7,8];

    public static $race = 7;

	// Don't forget to fill this array
	protected $fillable = ['date','stadium','category_id','subcategory_id'];

}
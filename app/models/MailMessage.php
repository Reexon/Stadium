<?php

class MailMessage extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'title' => 'required',
        'body' => 'required',
        'subject' => 'required',
        'to' => 'required',
	];

	// Don't forget to fill this array
	protected $fillable = [
        'title',
        'body',
        'to',
        'subject',
    ];

}
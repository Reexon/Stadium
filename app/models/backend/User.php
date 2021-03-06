<?php
namespace Backend\Model;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

    protected $primaryKey = 'id_user';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

    protected $perPage = 10;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    public static $rules = [
        'firstname' => 'required|alpha|min:2',
        'lastname'  => 'required|alpha|min:2',
        'email'     => 'required|email|unique:users',
        'mobile'    => 'required',
        'password'  => 'required|alpha_num|between:6,12|confirmed',
        'password_confirmation'=>'required|alpha_num|between:6,12',
    ];

    protected $fillable = ['firstname','lastname','email','password','city','address','mobile','alt_mobile','birth_date','cap'];

    protected $dates = ['birth_date'];

    public function payments(){
        return $this->hasMany('Backend\Model\Payment');
    }

    public function getFullnameAttribute(){
        return $this->firstname." ".$this->lastname;
    }

    public function getIsAdminAttribute(){
        return $this->id_user == 1;
    }
}

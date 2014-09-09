<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 03/09/14
 * Time: 11:18
 */

namespace Frontend\Controller;


use Backend\Model\User;
use Auth;
use View;
use Validator;
use Redirect;
use Input;
use Backend\Model\Payment;

class UsersController extends BaseController{

    public function payments(){

        $userInfo = User::with('payments')->findOrFail(Auth::id());
        return View::make($this->viewFolder."payments.index",compact('userInfo'));
    }
    public function paymentDetail($id_payment){

        $payment = Payment::with('user')->where('user_id','=',Auth::id())->findOrFail($id_payment);
        return View::make($this->viewFolder."payments.details",compact('payment'));
    }

    public function profile(){
        $userInfo = Auth::user();
        return View::make($this->viewFolder."profile",compact('userInfo'));
    }

    public function update(){

        $validator = Validator::make(
            $data = Input::all(),
            [
                'firstname' => 'required',
                'lastname'  => 'required',
                'email'     => 'required|email',
                'address'   => 'required',
                'city'      => 'required',
                'cap'       => 'required',
                'mobile'    => 'required'
            ]
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = User::find(Auth::id());
        $user->fill($data);
        $user->save();
        return Redirect::to('user/profile')->with('message','Information edited succesfully');
    }

} 
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

class UsersController extends BaseController{

    public function payments(){

        $userInfo = User::with('payments.orders.ticket')->findOrFail(Auth::id());
        return View::make($this->viewFolder."payments",compact('userInfo'));
    }

} 
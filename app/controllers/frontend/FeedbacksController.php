<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 07/09/14
 * Time: 08:38
 */

namespace Frontend\Controller;

use Backend\Model\Feedback;
use View;
use Input;
use Redirect;

class FeedbacksController extends BaseController{

    /**
     * Show the form for creating a new user
     *
     * @return Response
     */
    public function create($UUID)
    {

        $feedback = Feedback::where('uuid','=',$UUID)->with('payment.orders.ticket','payment.user')->get()->first();


        if(!is_object($feedback))
            return "No feedback found with this UUID";

        return View::make($this->viewFolder.'feedbacks.create',compact('feedback'));
    }


    public function submit(){

        $comment = Input::get('comment');
        $id_feedback = Input::get('id_feedback');

        //TODO:validation

        $feedback = Feedback::find($id_feedback);
        $feedback->comment = $comment;
        $feedback->rating = 5;
        $feedback->save();
        return Redirect::to('/')->with('message','Thank you for submitting your Feedback !');
    }

    public function show(){

        $feedback = Feedback::all();

        return View::make($this->viewFolder.'feedbacks.show',compact('feedback'));
    }
} 
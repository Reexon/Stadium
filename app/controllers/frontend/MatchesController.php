<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 01/09/14
 * Time: 16:19
 */

namespace Frontend\Controller;


use Backend\Model\Match;
use Frontend\Model\MatchSubscription;
use View;
use Input;
use Mail;
use Redirect;
use DB;
class MatchesController extends BaseController{

    /**
     * @author Loris D'antonio
     *
     * Display a listing of matches > current date
     *
     * @return Response
     */
    public function index(){
        //TODO: seleizonare solo i match prossimi, non tutti

        $matches = Match::where('date','>',DB::raw('CURDATE()'))
                        ->orderBy('date')
                        ->take(10)
                        ->get();


        return View::make('index',compact('matches'));
    }

    public function info($id){
        $match = Match::with('tickets')->findOrFail($id);

        return View::make('infoMatch',compact('match'));
    }

    public function signup($id){
        $user_email = Input::get('email');
        $data['ticket_id'] = $id;

        /*
         * Nella vista specificata , per accedere ai dati presenti in $data
         * bastera stampare la chiave... per esempio anzichè fare $data[ticket]
         * basterà fare $ticket
         */
        Mail::queue('emails.newticket', $data, function($message) use ($user_email)
        {
            $message->to($user_email, "Loris D'antonio")
                ->subject('Welcome to Cribbb!');
        });


        $matchSubscription = new  MatchSubscription();
        //TODO: Validation Before Save
        $matchSubscription->match_id = $id;
        $matchSubscription->email = $user_email;
        $matchSubscription->save();

        return Redirect::back()->with('success',"You've subscribed succesfully");

    }
}
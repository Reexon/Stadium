<?php

namespace Backend\Controller;

use View;
use Validator;
use Redirect;
use Input;
use Response;
use Backend\Model\Match;
use DB;

class MatchesController extends BaseController {

	/**
	 * Display a listing of matches
	 *
	 * @return Response
	 */
	public function index()
	{
        //prendo i match che non sono scaduti
		//$matches = Match::where('date','>',time())->paginate(15);
        $matches = Match::all();

		return View::make($this->viewFolder.'matches.index', compact('matches'));

	}

	/**
	 * Show the form for creating a new match
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make($this->viewFolder.'matches.create');
	}

	/**
	 * Store a newly created match in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

        /**
         * WARNIGN: non toccare questo metodo finchè non viene risolto il problema
         * @see  http://laravel.io/forum/08-26-2014-inputold-with-array-of-input
         */

        $home_team = Input::get('home_team');
        $guest_team = Input::get('guest_team');
        $stadium = Input::get('stadium');
        $date = Input::get('date');

        for($i = 0 ; $i < count($guest_team); $i++){
            $dataMatches = [
                '_token' => Input::get('_token'),
                'home_team'     =>  $home_team[$i],
                'guest_team'    =>  $guest_team[$i],
                'stadium'       =>  $stadium[$i],
                'date'          => date('Y-m-d',strtotime($date[$i]))
            ];

            $validator = Validator::make($data = $dataMatches, Match::$rules);

            if ($validator->fails())
            {
                return Redirect::back()->withErrors($validator);
            }

            //TODO: Bisogna Validare i dati prima di creare il match
            Match::create($dataMatches);
        }

       /*

       for($i = 0 ; $i < home_team)
        foreach($home_team as $key => $value )
        {
            $arrData[] = array(
                "order_id"      => Input::get('order_id'),
                "user_id"       => $user_id[$key],
                "item_id"       => $item_id[$key],
                "item_price"    => $item->price,
                "item_currency" => $item->currency,
                "quantity"      => 1
            );

        }*/

		/*$validator = Validator::make($data = Input::all(), Match::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Match::create($data);
		*/

		return Redirect::route('admin.matches.index');
	}

	/**
	 * Display the specified match.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$match = Match::findOrFail($id);

		return View::make($this->viewFolder.'matches.show', compact('match'));
	}

	/**
	 * Show the form for editing the specified match.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$match = Match::find($id);

		return View::make($this->viewFolder.'matches.edit', compact('match'));
	}

	/**
	 * Update the specified match in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$match = Match::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Match::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        /*
         * Solo per convertire la data da: DD-MM-YYYY a un formato compatibile con MySQL (YYYY-MM-DD)
         */
        $data['date'] = date("Y-m-d", strtotime($data['date']));

		$match->update($data);

	    return Redirect::route('admin.matches.index')->with('success','Match Updated Succesfully');
	}

	/**
	 * Remove the specified match from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Match::destroy($id);

		return Redirect::route('admin.matches.index');
	}

    public function findTicket(){

        $match = Match::find(Input::get('match_id'));
        return Response::json( $match->tickets );
    }

}

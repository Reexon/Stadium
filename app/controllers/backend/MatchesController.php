<?php

namespace Backend\Controller;

use Backend\Model\Category;
use Backend\Model\Event;
use Backend\Model\Events;
use Backend\Model\SubCategory;
use View;
use Validator;
use Redirect;
use Input;
use Response;
use Backend\Model\Match;
use Backend\Model\Team;

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
        $matches = Match::with('homeTeam','guestTeam')
            ->whereIn('category_id', Match::$category)
            ->orderBy('date','desc')
            ->paginate();

		return View::make($this->viewFolder.'matches.index', compact('matches'));

	}

	/**
	 * Show the form for creating a new match
	 *
	 * @return Response
	 */
	public function create()
	{
        $teams = Team::whereIn('category_id',Match::$category)->lists('name', 'id_team');
        $category = Category::whereIn('id_category',Match::$category)->lists('name','id_category');
		return View::make($this->viewFolder.'matches.create',compact('teams','category'));
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

        $home_id = Input::get('home_id');
        $guest_id = Input::get('guest_id');
        $stadium = Input::get('stadium');
        $date = Input::get('date');
        $category = Input::get('category_id');
        $subcategory = Input::get('subcategory_id');

        for($i = 0 ; $i < count($guest_id); $i++){
            $dataMatches = [
                '_token' => Input::get('_token'),
                'home_id'     =>  $home_id[$i],
                'guest_id'    =>  $guest_id[$i],
                'stadium'       =>  $stadium[$i],
                'date'          => date('Y-m-d',strtotime($date[$i])),
                'category_id'   => $category[$i],
                'subcategory_id'=> $subcategory[$i]
            ];

            $validator = Validator::make($data = $dataMatches, Match::$rules);

            if ($validator->fails())
            {
                return Redirect::back()->withErrors($validator);
            }

            //TODO: Bisogna Validare i dati prima di creare il match
            Match::create($dataMatches);
        }

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
		$match = Match::with('tickets.orders.payment.user')->findOrFail($id);

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
        $teams = Team::whereIn('category_id',Match::$category)->lists('name', 'id_team');

        $categories = Category::whereIn('id_category',Match::$category);
        $subcategories = SubCategory::where('category_id','=',$categories->first()->id_category)->lists('name','id_subcategory');
        $categories = $categories->lists('name','id_category');

		return View::make($this->viewFolder.'matches.edit', compact('match','teams','categories','subcategories'));
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

        //avvisare gli utenti che hanno acquistato biglietto, della modifica ?
        if(Input::get('send_notifications')){
            //TODO:inviare mail a utenti
        }

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

        $match = Event::join('tickets','event_id','=','id_event')->find(Input::get('event_id'));
        if(!is_object($match))
            return -1;
        return Response::json( $match->tickets );
    }

    /*
     * Visualizza tutte le partite di una certa squadra
     */
    public function findMatchesFromTeam($id_team){
        $matches = Match::where('guest_id','=',$id_team)->orWhere('home_id','=',$id_team)->paginate();

        return View::make($this->viewFolder."matches.team",compact('matches'));
    }

}

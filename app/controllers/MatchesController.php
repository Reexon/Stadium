<?php

class MatchesController extends \BaseController {

	/**
	 * Display a listing of matches
	 *
	 * @return Response
	 */
	public function index()
	{
		$matches = Match::all();

		return View::make('matches.index', compact('matches'));
	}

	/**
	 * Show the form for creating a new match
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('matches.create');
	}

	/**
	 * Store a newly created match in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

        $home_team = Input::get('home_team');
        $guest_team = Input::get('guest_team');

        for($i = 0 ; $i < count($guest_team); $i++){
            $dataMatches = [
                'home_team'     =>  $home_team[$i],
                'guest_team'    =>  $guest_team[$i]
            ];

            //TODO: Bisogna Validare i dati prima di creare il match
            Match::create($dataMatches);
        }

       /* for($i = 0 ; $i < home_team)
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

		Match::create($data);*/

		return Redirect::route('matches.index');
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

		return View::make('matches.show', compact('match'));
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

		return View::make('matches.edit', compact('match'));
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

		$match->update($data);

		return Redirect::route('matches.index');
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

		return Redirect::route('matches.index');
	}

}

<?php
namespace Backend\Controller;

use Backend\Model\MatchSubscription;
use View;
use Validator;
use Input;
use Redirect;
use DB;

class MatchSubscriptionsController extends BaseController {

	/**
	 * Display a listing of matchsubscriptions
	 *
	 * @return Response
	 */
	public function index()
	{
		$subscriptions = DB::table('matches as m')
            ->select('*',DB::raw('CONCAT(t1.name," - ",t2.name," (",DATE_FORMAT(date,"%d/%m/%Y"),")") AS label_match'))
            ->join('teams as t1','t1.id_team','=','m.home_id') //prelevo nome squadra in casa
            ->join('teams as t2','t2.id_team','=','m.guest_id') //prelevo nome squadra ospite
            ->join('match_subscriptions','match_id','=','id_match')
            ->paginate(10);

        return View::make($this->viewFolder.'MatchSubscriptions.index', compact('subscriptions'));
	}

	/**
	 * Show the form for creating a new matchsubscription
	 *
	 * @return Response
	 */
	public function create()
	{
        $matches = DB::table('matches as m')
            ->select('id_match',DB::raw('CONCAT(t1.name," - ",t2.name," (",DATE_FORMAT(date,"%d/%m/%Y"),")") AS label_match'))
            ->join('teams as t1','t1.id_team','=','m.home_id') //prelevo nome squadra in casa
            ->join('teams as t2','t2.id_team','=','m.guest_id') //prelevo nome squadra ospite
            ->orderBy('date','desc')
            ->where('date','>',DB::raw('CURDATE()'))
            ->lists('label_match','id_match');

        return View::make($this->viewFolder.'MatchSubscriptions.create',compact('matches'));
	}

	/**
	 * Store a newly created matchsubscription in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Matchsubscription::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Matchsubscription::create($data);

		return Redirect::route('admin.MatchSubscriptions.index');
	}

	/**
	 * Show the form for editing the specified matchsubscription.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$matchsubscription = Matchsubscription::find($id);

		return View::make($this->viewFolder.'MatchSubscriptions.edit', compact('matchsubscription'));
	}

	/**
	 * Update the specified matchsubscription in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$matchsubscription = Matchsubscription::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Matchsubscription::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$matchsubscription->update($data);

		return Redirect::route('admin.MatchSubscriptions.index');
	}

	/**
	 * Remove the specified matchsubscription from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Matchsubscription::destroy($id);

		return Redirect::route('admin.MatchSubscriptions.index');
	}

}

<?php
namespace Backend\Controller;
use Backend\Model\Category;
use View;
use Validator;
use Redirect;
use Input;
use Backend\Model\Team;
use Backend\Model\Match;
class TeamsController extends BaseController {

	/**
	 * Display a listing of teams
	 *
	 * @return Response
	 */
	public function index()
	{
		$teams = Team::where('category_id','=',Match::$football)->paginate();

		return View::make($this->viewFolder.'teams.index', compact('teams'));
	}

	/**
	 * Show the form for creating a new team
	 *
	 * @return Response
	 */
	public function create()
	{
        $event_list = Category::all()->lists('name','id_category');
		return View::make($this->viewFolder.'teams.create',compact('event_list'));
	}

	/**
	 * Store a newly created team in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

        /**
         * WARNIGN: non toccare questo metodo finchè non viene risolto il problema
         * @see  http://laravel.io/forum/08-26-2014-inputold-with-array-of-input
         */

        $team_names = Input::get('name');

        for($i = 0 ; $i < count($team_names); $i++){
            $dataMatches = [
                '_token'        => Input::get('_token'),
                'name'          => $team_names[$i],
                'category_id'   => Match::$football,
            ];

            $validator = Validator::make($teamData = $dataMatches, Team::$rules);

            if ($validator->fails())
            {
                return Redirect::back()->withErrors($validator);
            }

            //TODO: Bisogna Validare i dati prima di creare il match
            Team::create($teamData);

        }

		return Redirect::route('admin.teams.index')->with('success','Team Create');
	}

	/**
	 * Display the specified team.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$team = Team::findOrFail($id);

		return View::make($this->viewFolder.'teams.show', compact('team'));
	}

	/**
	 * Show the form for editing the specified team.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$team = Team::find($id);

		return View::make($this->viewFolder.'teams.edit', compact('team'));
	}

	/**
	 * Update the specified team in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$team = Team::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Team::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$team->update($data);

		return Redirect::route('admin.teams.index');
	}

	/**
	 * Remove the specified team from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Team::destroy($id);

		return Redirect::route('admin.teams.index');
	}

}

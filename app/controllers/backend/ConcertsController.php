<?php
namespace Backend\Controller;

use Backend\Model\Concert;
use Backend\Model\Artist;
use View;
use Validator;
use Input;
use Redirect;

class ConcertsController extends BaseController {

	/**
	 * Display a listing of concerts
	 *
	 * @return Response
	 */
	public function index()
	{
		$concerts = Concert::join('teams','home_id','=','id_team')->paginate();

		return View::make($this->viewFolder.'concerts.index', compact('concerts'));
	}

	/**
	 * Show the form for creating a new concert
	 *
	 * @return Response
	 */
	public function create()
	{
        $artists = Artist::all()->lists('name','id_team');
		return View::make($this->viewFolder.'concerts.create',compact('artists'));
	}

	/**
	 * Store a newly created concert in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        /**
         * WARNIGN: non toccare questo metodo finchè non viene risolto il problema
         * @see  http://laravel.io/forum/08-26-2014-inputold-with-array-of-input
         */

        $artist_id = Input::get('artist_id');
        $stadium = Input::get('stadium');
        $date = Input::get('date');

        //loop sul formato delle date
        foreach ($date as $data){
            if(!strtotime($data))
                return Redirect::back()->withErrors('Date Error');
        }

        for($i = 0 ; $i < count($artist_id); $i++){

            $dataMatches = [
                '_token'        => Input::get('_token'),
                'home_id'       => $artist_id[$i],
                'stadium'       => $stadium[$i],
                'date'          => date('Y-m-d',strtotime($date[$i])),
                'category_id'   => Concert::$concert
            ];

            $validator = Validator::make($data = $dataMatches, Concert::$rules);

            if ($validator->fails())
            {
                return Redirect::back()->withErrors($validator);
            }

            //TODO: Bisogna Validare i dati prima di creare il match
            Concert::create($dataMatches);
        }

        return Redirect::route('admin.concerts.index');

	}

	/**
	 * Display the specified concert.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$concert = Concert::findOrFail($id);

		return View::make($this->viewFolder.'concerts.show', compact('concert'));
	}

	/**
	 * Show the form for editing the specified concert.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$concert = Concert::find($id);

		return View::make($this->viewFolder.'concerts.edit', compact('concert'));
	}

	/**
	 * Update the specified concert in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$concert = Concert::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Concert::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$concert->update($data);

		return Redirect::route('admin.concerts.index');
	}

	/**
	 * Remove the specified concert from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Concert::destroy($id);

		return Redirect::route('admin.concerts.index');
	}

}

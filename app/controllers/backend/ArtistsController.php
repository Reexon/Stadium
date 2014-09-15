<?php
namespace Backend\Controller;

use Backend\Model\Artist;
use View;
use Validator;
use Input;
use Redirect;

class ArtistsController extends BaseController {

	/**
	 * Display a listing of artists
	 *
	 * @return Response
	 */
	public function index()
	{

        $artists = Artist::select('id_team as id_artist','name')->where('category_id','=','2')->paginate();

		return View::make($this->viewFolder.'artists.index', compact('artists'));
	}

	/**
	 * Show the form for creating a new artist
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make($this->viewFolder.'artists.create');
	}

	/**
	 * Store a newly created artist in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        /**
         * WARNIGN: non toccare questo metodo finchè non viene risolto il problema
         * @see  http://laravel.io/forum/08-26-2014-inputold-with-array-of-input
         */

        $artists_names = Input::get('name');

        for($i = 0 ; $i < count($artists_names); $i++){
            $dataArtists = [
                '_token'        => Input::get('_token'),
                'name'          => $artists_names[$i],
                'category_id'   => 2
            ];

            $validator = Validator::make($artistData = $dataArtists, Artist::$rules);

            if ($validator->fails())
            {
                return Redirect::back()->withErrors($validator);
            }

            //TODO: Bisogna Validare i dati prima di creare il match
            Artist::create($artistData);

        }

		return Redirect::route('admin.artists.index')->with('success','Artists Created Succesfully');
	}

	/**
	 * Display the specified artist.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$artist = Artist::findOrFail($id);

		return View::make($this->viewFolder.'artists.show', compact('artist'));
	}

	/**
	 * Show the form for editing the specified artist.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$artist = Artist::find($id);

		return View::make($this->viewFolder.'artists.edit', compact('artist'));
	}

	/**
	 * Update the specified artist in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$artist = Artist::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Artist::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$artist->update($data);

		return Redirect::route('admin.artists.index');
	}

	/**
	 * Remove the specified artist from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Artist::destroy($id);

		return Redirect::route('admin.artists.index');
	}

}

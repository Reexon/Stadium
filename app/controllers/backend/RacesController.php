<?php
namespace Backend\Controller;

use Backend\Model\Category;
use View;
use Validator;
use Input;
use Redirect;
use Backend\Model\Race;
use Backend\Model\SubCategory;
use DB;
use Backend\Model\Event;
class RacesController extends BaseController {

	/**
	 * Display a listing of races
	 *
	 * @return Response
	 */
	public function index()
	{
		$races = Event::race()->paginate();

		return View::make($this->viewFolder.'races.index', compact('races'));
	}

	/**
	 * Show the form for creating a new race
	 *
	 * @return Response
	 */
	public function create()
	{
        $category = Category::race()->lists('name','id_category');
		return View::make($this->viewFolder.'races.create',compact('category'));
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

        $stadium = Input::get('stadium');
        $date = Input::get('date');
        $category = Input::get('category_id');
        $subcategory = Input::get('subcategory_id');

        //loop sul formato delle date
        foreach ($date as $data){
            if(!strtotime($data))
                return Redirect::back()->withErrors('Date Error');
        }

        for($i = 0 ; $i < count($stadium); $i++){

            $dataRaces = [
                'stadium'       => $stadium[$i],
                'date'          => date('Y-m-d',strtotime($date[$i])),
                'category_id'   => $category[$i],
                'subcategory_id'=> $subcategory[$i]
            ];

            $validator = Validator::make($data = $dataRaces, Race::$rules);

            if ($validator->fails())
            {
                return Redirect::back()->withErrors($validator);
            }

            //TODO: Bisogna Validare i dati prima di creare il match
            Race::create($dataRaces);
        }

        return Redirect::route('admin.races.index');

	}

	/**
	 * Display the specified concert.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$race = Race::findOrFail($id);

		return View::make($this->viewFolder.'races.show',compact('race'));
	}

	/**
	 * Show the form for editing the specified concert.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$race = Event::race()->find($id);
        $categories = Category::race()->lists('name','id_category');
        $subcategories = SubCategory::whereIn('category_id',Race::$category)->lists('name','id_subcategory');


        $usersToBeNotified =DB::select(
            DB::raw('SELECT * FROM users
                      INNER JOIN payments ON id_user = payments.user_id
                      INNER JOIN orders ON id_payment = orders.payment_id
                      INNER JOIN tickets ON id_ticket = orders.ticket_id
                      INNER JOIN events ON id_event = tickets.event_id
                      WHERE events.id_event = ?')
            ,[$id]);
		return View::make($this->viewFolder.'races.edit', compact('race','categories','usersToBeNotified','subcategories'));
	}

	/**
	 * Update the specified race in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		$race = Race::findOrFail($id);

        if(!strtotime(Input::get('date')))
            return Redirect::back()->withErrors('Date Error');

		$validator = Validator::make($data = Input::all(), Race::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        //converto la data solo dopo validazione
        $data['date'] = date("Y-m-d", strtotime(Input::get('date')));

		$race->update($data);

        //avvisare gli utenti che hanno acquistato biglietto, della modifica ?
        if(Input::get('send_notifications')){
            //TODO:inviare mail a utenti
        }

        return Redirect::route('admin.races.index');
	}

	/**
	 * Remove the specified races from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Race::destroy($id);

		return Redirect::route('admin.races.index');
	}

}

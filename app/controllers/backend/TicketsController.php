<?php
namespace Backend\Controller;

use Backend\Model\Ticket;
use View;
use Backend\Model\Match;
use DB;
use Input;
use Validator;
use Redirect;

class TicketsController extends \BaseController {

	/**
	 * Display a listing of tickets
	 *
	 * @return Response
	 */
	public function index()
	{
		$tickets = Ticket::all();
		return View::make('tickets.index', compact('tickets'));
	}

	/**
	 * Show the form for creating a new ticket
	 * @param int   $match_id   viene valorizzato quando viene effettuata una chiamata /tickets/create/4
     *                          l'unica utilità è che viene caricato il form di creazione con il match gia selezionato.
	 * @return Response
	 */
	public function create($match_id = 0)
	{
        $matches = Match::select('id_match', DB::raw('CONCAT(home_team, " - ", guest_team) AS label_match'))->take(10)
        ->orderBy('date')
        ->lists('label_match', 'id_match');
        return View::make('tickets.create', compact('matches','match_id'));
	}

	/**
	 * Store a newly created ticket in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

        /**
         * WARNIGN: non toccare questo metodo finchè non viene risolto il problema
         * @see  http://laravel.io/forum/08-26-2014-inputold-with-array-of-input
         */

        $ticket_type = Input::get('label');
        $ticket_price = Input::get('price');
        $ticket_matchID = Input::get('match_id');
        $ticket_quantity = Input::get('quantity');

        for($i = 0; $i < count($ticket_type); $i++){

            $dataTicket = [
                '_token' => Input::get('_token'),
                'label' => $ticket_type[$i],
                'price' => $ticket_price[$i],
                'match_id' => $ticket_matchID[$i],
                'quantity' => $ticket_quantity[$i],
            ];

           $validator = Validator::make($data = $dataTicket, Ticket::$rules);


            if ($validator->fails())
            {
                return Redirect::back()->withErrors($validator);
            }

            Ticket::create($dataTicket);
        }

        /*
		$validator = Validator::make($data = Input::all(), Ticket::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Ticket::create($data);
        */

		return Redirect::route('admin.tickets.index')->with('success','Ticket Created Succesfully');
	}

	/**
	 * Display the specified ticket.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$ticket = Ticket::findOrFail($id);

		return View::make('tickets.show', compact('ticket'));
	}

	/**
	 * Show the form for editing the specified ticket.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ticket = Ticket::find($id);

        //TODO:selezionare solo i match prossimi
        $matches = Match::select('id_match', DB::raw('CONCAT(home_team, " - ", guest_team) AS label_match'))->take(10)
            ->orderBy('date')
            ->lists('label_match', 'id_match');
		return View::make('tickets.edit', compact('ticket','matches'));
	}

	/**
	 * Update the specified ticket in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$ticket = Ticket::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Ticket::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$ticket->update($data);

		return Redirect::route('admin.tickets.index');
	}

	/**
	 * Remove the specified ticket from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Ticket::destroy($id);

		return Redirect::route('admin.tickets.index');
	}

}

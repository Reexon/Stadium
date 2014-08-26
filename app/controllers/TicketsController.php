<?php

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
	 *
	 * @return Response
	 */
	public function create()
	{
        $matches = Match::select('id_match', DB::raw('CONCAT(home_team, " - ", guest_team) AS label_match'))->take(10)
        ->orderBy('date')
        ->lists('label_match', 'id_match');
		return View::make('tickets.create', compact('matches'));
	}

	/**
	 * Store a newly created ticket in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $ticket_type = Input::get('label');
        $ticket_price = Input::get('price');
        $ticket_matchID = Input::get('match_id');

        for($i = 0; $i < count($ticket_type); $i++){
            //TODO: Bisogna Validare i dati prima di creare il ticket

            $dataTicket = [
                '_token' => Input::get('_token'),
                'label' => $ticket_type[$i],
                'price' => $ticket_price[$i],
                'match_id' => $ticket_matchID[$i],
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

		return Redirect::route('tickets.index')->with('success','Ticket Created Succesfully');
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

		return View::make('tickets.edit', compact('ticket'));
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

		return Redirect::route('tickets.index');
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

		return Redirect::route('tickets.index');
	}

}

<?php
namespace Backend\Controller;

use Backend\Model\Ticket;
use Frontend\Model\MatchSubscription;
use Illuminate\Events\Subscriber;
use View;
use Backend\Model\Match;
use DB;
use Input;
use Validator;
use Redirect;
use Response;
use Mail;

class TicketsController extends BaseController {

	/**
	 * Display a listing of tickets
	 *
	 * @return Response
	 */
	public function index()
	{
		$tickets = Ticket::paginate();
		return View::make($this->viewFolder.'tickets.index', compact('tickets'));
	}

	/**
	 * Show the form for creating a new ticket
	 * @param int   $match_id   viene valorizzato quando viene effettuata una chiamata /tickets/create/4
     *                          l'unica utilità è che viene caricato il form di creazione con il match gia selezionato.
	 * @return Response
	 */
	public function create($match_id = 0)
	{

        $match = Match::find($match_id);

        $matches = DB::table('matches as m')
            ->select('id_match',DB::raw('CONCAT(t1.name," - ",t2.name," (",DATE_FORMAT(date,"%d/%m/%Y"),")") AS label_match'))
            ->join('teams as t1','t1.id_team','=','m.home_id')
            ->join('teams as t2','t2.id_team','=','m.guest_id')
            ->orderBy('date','desc')
            ->lists('label_match','id_match');

        return View::make($this->viewFolder.'tickets.create', compact('matches','match','match_id'));
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

        if(Input::get('send_notifications') == "yes" ){
            $subscribers = MatchSubscription::select('email')->where('match_id','=',$ticket_matchID[0])->get();

            $match = Match::find($ticket_matchID[0]);
            $data['match'] = serialize($match);//lo serializzo per utilizzarlo nel template mail
            Mail::queue('emails.newticket', $data, function($message) use ($subscribers,$match)
            {
                foreach ($subscribers as $subscriber)
                    $message->to($subscriber->email)->subject('New Tickets Avvailable for '.$match->homeTeam->name ." vs ". $match->guestTeam->name);
            });
        }

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
        $ticket = Ticket::with('match','orders.payment.user')->findOrFail($id);
		return View::make($this->viewFolder.'tickets.show', compact('ticket'));
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
        $matches = DB::table('matches as m')
            ->select('id_match',DB::raw('CONCAT(t1.name," - ",t2.name," (",DATE_FORMAT(date,"%d/%m/%Y"),")") AS label_match'))
            ->join('teams as t1','t1.id_team','=','m.home_id')
            ->join('teams as t2','t2.id_team','=','m.guest_id')
            ->orderBy('date','desc')
            ->lists('label_match','id_match');

		return View::make($this->viewFolder.'tickets.edit', compact('ticket','matches'));
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

    public function selledForMatch($id_match){
        $tickets = DB::select('SELECT label,ticket_id,price,
        SUM(orders.quantity)as quantity,
        SUM(orders.quantity * tickets.price)as total_price
        FROM payments
        INNER JOIN orders ON id_payment = payment_id
        INNER JOIN tickets ON ticket_id = id_ticket
        WHERE tickets.match_id = ?
        GROUP BY ticket_id
        ',[$id_match]);

        return View::make($this->viewFolder.'tickets.selled',compact('tickets'));
    }

    /*
     * Richiesta ajax tramite POST durante creazione pagamento
     */
    public function findQuantity(){
        $ticket = Ticket::find(Input::get('ticket_id'));
        return Response::json( $ticket->quantity );
    }
}

<?php
namespace Backend\Controller;

use Backend\Model\Concert;
use Backend\Model\Ticket;
use Frontend\Model\MatchSubscription;
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
		$match_tickets = Ticket::where('category_id','=',Match::$football)->paginate();
        $concert_tickets = Ticket::where('category_id','=',Concert::$concert)->paginate();
		return View::make($this->viewFolder.'tickets.index', compact('match_tickets','concert_tickets'));
	}

	/**
	 * Show the form for creating a new ticket
	 * @param int   $match_id   viene valorizzato quando viene effettuata una chiamata /tickets/create/4
     *                          l'unica utilità è che viene caricato il form di creazione con il match gia selezionato.
	 * @return Response
	 */
	public function create($category_id,$match_id = 0)
	{

        //se la categoria è una di quelle da gestire tipo concerto...
        if(in_array($category_id,Concert::$category)){
            $match = Concert::with('subscribers')->find($match_id);
            $events = Concert::join('teams','home_id','=','id_team')
                ->select('id_event',DB::raw('CONCAT(name," (",DATE_FORMAT(date,"%d/%m/%Y"),")") as name'))
                ->where('teams.category_id','=',$category_id);

            if($match_id != 0)
                $events = $events->where('id_event','=',$match_id);

            $events = $events->orderBy('date','desc')
                ->lists('name','id_event');

        //se la categoria è una di quelle da gestire come match..
        }else if(in_array($category_id,Match::$category)){
            $match = Match::with('subscribers')->find($match_id);

            $events = DB::table('events as m')
                ->select('id_event',DB::raw('CONCAT(t1.name," - ",t2.name," (",DATE_FORMAT(date,"%d/%m/%Y"),")") AS label_match'))
                ->join('teams as t1','t1.id_team','=','m.home_id')
                ->join('teams as t2','t2.id_team','=','m.guest_id')
                ->where('m.category_id','=',$category_id);

            if($match_id != 0)//in questo modo uno avrà solo un match nella select
                $events = $events->where('m.id_event','=',$match_id);

            $events = $events->orderBy('date','desc')->lists('label_match','id_event');
        }


        return View::make($this->viewFolder.'tickets.create', compact('events','match','match_id','category_id'));
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
        $ticket_eventID = Input::get('event_id');
        $ticket_quantity = Input::get('quantity');

        //campo nascosto nel form per capire di che categoria è l'evento
        //$category_event = Input::get('category_id');

        for($i = 0; $i < count($ticket_type); $i++){

            $dataTicket = [
                '_token'        => Input::get('_token'),
                'label'         => $ticket_type[$i],
                'price'         => $ticket_price[$i],
                'event_id'      => $ticket_eventID[$i],
                'quantity'      => $ticket_quantity[$i]
            ];

           $validator = Validator::make($data = $dataTicket, Ticket::$rules);

            if ($validator->fails())
            {
                return Redirect::back()->withErrors($validator);
            }

            Ticket::create($dataTicket);
        }

        //Se è stato flaggato l'invio delle notifiche
        if(Input::get('send_notifications') == "yes" ){
            $subscribers = MatchSubscription::select('email')->where('event_id','=',$ticket_eventID[0])->get();

            $match = Match::find($ticket_eventID[0]);
            $data['match'] = serialize($match);//lo serializzo per utilizzarlo nel template mail
            Mail::queue('emails.newticket', $data, function($message) use ($subscribers,$match)
            {
                foreach ($subscribers as $subscriber)
                    $message->to($subscriber->email)->subject('New Tickets Avvailable for '.$match->homeTeam->name ." vs ". $match->guestTeam->name);
            });
        }

		return Redirect::back()->with('success','Ticket Created Succesfully');
	}

	/**
	 * Display the specified ticket.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $ticket = Ticket::with('event','orders.payment.user')->findOrFail($id);
		return View::make($this->viewFolder.'tickets.show', compact('ticket'));
	}

	/**
	 * Show the form for editing the specified ticket.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($category,$id)
	{

		$ticket = Ticket::where('category_id','=',$category)->find($id);


        //TODO:selezionare solo i match prossimi
        $matches = DB::table('events as m')
            ->select('id_event',DB::raw('CONCAT(t1.name," - ",t2.name," (",DATE_FORMAT(date,"%d/%m/%Y"),")") AS label_match'))
            ->join('teams as t1','t1.id_team','=','m.home_id')
            ->join('teams as t2','t2.id_team','=','m.guest_id')
            ->orderBy('date','desc')
            ->lists('label_match','id_event');

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

		return Redirect::back()->with('success','Tickets Updated Succesfully');
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

    public function selledForMatch($id_event){
        $tickets = DB::select('SELECT label,ticket_id,price,
        SUM(orders.quantity)as quantity,
        SUM(orders.quantity * tickets.price)as total_price
        FROM payments
        INNER JOIN orders ON id_payment = payment_id
        INNER JOIN tickets ON ticket_id = id_ticket
        WHERE tickets.event_id = ?
        GROUP BY ticket_id
        ',[$id_event]);

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

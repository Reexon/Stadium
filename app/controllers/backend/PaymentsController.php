<?php
namespace Backend\Controller;

use Backend\Model\Payment;
use View;
use Backend\Model\User;
use Backend\Model\Match;
use Backend\Model\Ticket;
use Backend\Model\Order;
use DB;
use Input;
use Validator;
use Redirect;
use Response;

class PaymentsController extends BaseController {

	/**
	 * Display a listing of payments
	 *
	 * @return Response
	 */
	public function index()
	{
		$payments = Payment::orderBy('pay_date','desc')->paginate(15);

		return View::make($this->viewFolder.'payments.index', compact('payments'));
	}

	/**
	 * Show the form for creating a new payment
	 *
	 * @return Response
	 */
	public function create()
	{
        //seleziono solo i match dove è stato creato almeno 1 ticket
        $matches = Match::join('tickets','match_id','=','id_match')
            ->select('id_match', DB::raw('CONCAT(home_team, " - ", guest_team, " (", DATE_FORMAT(date,"%d/%m/%Y") ," )") AS label_match'))
            ->take(10)
            ->orderBy('date')
            ->lists('label_match', 'id_match');

        $users = User::select('id_user',DB::raw('CONCAT(firstname, " ", lastname) AS name'))->lists('name','id_user');

		return View::make($this->viewFolder.'payments.create',compact('matches','users'));
	}

	/**
	 * Store a newly created payment in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        /**
         * WARNIGN: non toccare questo metodo finchè non viene risolto il problema
         * @see  http://laravel.io/forum/08-26-2014-inputold-with-array-of-input
         */

        $user_id = Input::get('user_id');
        $pay_date = Input::get('pay_date');
        $ticket_id = Input::get('ticket_id');
        $quantity = Input::get('quantity');

        $dataPayment =[
            'pay_date' => date('Y-m-d',strtotime($pay_date)),
            'total' => 0 //default 0 , verrà fatto update + avanti
        ];

        $validatePayment =  Validator::make($data = $dataPayment, Payment::$rules);
        if ($validatePayment->fails())
        {
            return Redirect::back()->withErrors($validatePayment);
        }


        /*
         * Creo un oggetto payment e lo inizializzo
         * Cerco l'user da associare al payment
         * Salvo la relazione
         */
        $payment = new Payment($dataPayment);
        $user = User::find($user_id);
        $payment = $user->payments()->save($payment);

        for($i = 0; $i < count($ticket_id); $i++){

            $dataOrder = [
                'quantity' => $quantity[$i]
            ];

            $validateOrder = Validator::make($data = $dataOrder, Order::$rules);
            if ($validateOrder->fails())
            {
                return Redirect::back()->withErrors($validateOrder);
            }

            /*
             * Creo Ordine e lo inizializzo con i dati appena validati
             * Cerco il modello ticket con id
             * All'ordine (che ancora non esiste) gli associo il ticket
             * All'ordine (che ancora non esiste) gli associo il pagamento
             * Salvo infine il pagamento inserendolo in relazione con i Payment
             * Aggiorno il totale del pagamento e faccio update
             */
            $order = new Order($dataOrder);
            $ticket = Ticket::find($ticket_id[$i]);
            $order = $order->ticket()->associate($ticket);
            $order = $order->payment()->associate($payment);
            $payment->orders()->save($order);
            $payment->total += $order->quantity * $ticket->price;
            $payment->save();
        }


		return Redirect::route('admin.payments.index');
	}

	/**
	 * Display the specified payment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//$payment = Payment::findOrFail($id);
        $payment = Payment::with('user','orders.ticket.match')->findOrFail($id);
		return View::make($this->viewFolder.'payments.show', compact('payment'));
	}

	/**
	 * Show the form for editing the specified payment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$payment = Payment::find($id);
        $matches = Match::select('id_match', DB::raw('CONCAT(home_team, " - ", guest_team, " (", DATE_FORMAT(date,"%d/%m/%Y") ," )") AS label_match'))->take(10)
            ->orderBy('date')
            ->lists('label_match', 'id_match');

        $users = User::select('id_user',DB::raw('CONCAT(firstname, " ", lastname) AS name'))->lists('name','id_user');

		return View::make($this->viewFolder.'payments.edit', compact('payment','matches','users'));
	}

	/**
	 * Update the specified payment in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$payment = Payment::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Payment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$payment->update($data);

		return Redirect::route('admin.payments.index');
	}

	/**
	 * Remove the specified payment from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Payment::destroy($id);

		return Redirect::route('admin.payments.index');
	}

}

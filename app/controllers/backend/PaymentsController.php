<?php
namespace Backend\Controller;

use Backend\Model\Event;
use Backend\Model\Feedback;
use Backend\Model\Payment;
use View;
use Backend\Model\User;
use Str;
use Backend\Model\Ticket;
use Backend\Model\Order;
use DB;
use Input;
use Validator;
use Redirect;
use Response;
use Mail;
use Backend\Model\Concert;
use Backend\Model\Match;
class PaymentsController extends BaseController {

	/**
	 * Display a listing of payments
	 *
	 * @return Response
	 */
	public function index()
	{
        //pagamenti andati a buon fine
		$successPayments = Payment::with('orders','user')->orderBy('pay_date','desc')->where('status','=','APPROVED')->get();

        //pagamenti con autorizzazione negata
        $failedPayments = Payment::with('orders','user')->orderBy('pay_date','desc')->where('status','=','NOT APPROVED')->get();

        //pagamenti con errore nei dati (carta,scadenza,credito insuff, ecc)
        $problemPayments = Payment::with('orders','user')->orderBy('pay_date','desc')->whereNull('status')->get();

		return View::make($this->viewFolder.'payments.index', compact('failedPayments','problemPayments','successPayments'));
	}

    /**
     * Visualizza Tutti i pagamenti relativi alla categoria di evento.
     *
     * @param $category_id id della categoria da visualizzare
     */
    public function showCategory($category_id){

        if(in_array($category_id,Match::$category)){
            //TODO: da aggiungere: where category_id = $category_id
            $payments = Payment::with('user','feedback','orders.ticket.category')->orderBy('pay_date','desc')->paginate();
        }else if(in_array($category_id,Concert::$category)){
            //TODO:Selezionare gli eventi di tipo concerto
            $payments = Payment::with('user','feedback','orders.ticket.category')->paginate();
        }
        return View::make($this->viewFolder.'payments.category', compact('payments'));
    }
	/**
	 * Show the form for creating a new payment
	 *
	 * @return Response
	 */
	public function create($category_id)
	{

        if(in_array($category_id,Match::$category)){
            $events = DB::table('events as m')
                ->select('id_event',DB::raw('CONCAT(t1.name," - ",t2.name," (",DATE_FORMAT(date,"%d/%m/%Y"),")") AS label_match'))
                ->join('teams as t1','t1.id_team','=','m.home_id') //prelevo nome squadra in casa
                ->join('teams as t2','t2.id_team','=','m.guest_id') //prelevo nome squadra ospite
                ->join('tickets','id_event','=','event_id')//solo match che hanno qualche ticket nella tabella ticket
                ->where('quantity','>',0) //i ticket presenti nella tabella devono essere di quantita >0
                ->where('m.category_id','=',$category_id)
                ->orderBy('date','desc')
                ->lists('label_match','id_event');

        }else if (in_array($category_id,Concert::$category)){
            $events = Concert::select('id_event',DB::raw('teams.name as name'))
                ->join('teams','home_id','=','id_team')
                ->join('tickets','event_id','=','id_event')
                ->where('quantity','>',0)
                ->where('teams.category_id','=',$category_id)
                ->orderBy('date','desc')
                ->lists('name','id_event');
        }

        $users = User::select('id_user',DB::raw('CONCAT(firstname, " ", lastname) AS name'))->lists('name','id_user');

		return View::make($this->viewFolder.'payments.create',compact('events','users'));
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

        if(!strtotime($pay_date))
            return Redirect::back()->withErrors('Date Error');

            $dataPayment =[
                'pay_date' => date('Y-m-d',strtotime($pay_date)),
                'total' => 0 //default 0 , verrà fatto update + avanti
            ];


        $validatePayment =  Validator::make($data = $dataPayment, Payment::$rules);
        if ($validatePayment->fails())
        {
            return Redirect::back()->withErrors($validatePayment);
        }


        $feedback = new Feedback(['uuid' => Str::random(32)]);
        $feedback->save();

        /*
         * Creo un oggetto payment e lo inizializzo
         * Cerco l'user da associare al payment
         * Salvo la relazione
         * Genero l'uuid del feedback e lo salvo
         */

        $payment = new Payment($dataPayment);
        $user = User::find($user_id);
        $payment->feedback()->associate($feedback);
        $payment = $user->payments()->save($payment);

        for($i = 0; $i < count($ticket_id); $i++){

            $dataOrder = [
                'quantity' => $quantity[$i],
                'ticket_id'=> $ticket_id[$i]
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
             * Aggiorno il totale del pagamento e faccio
             * Aggiorno quantità di ticket disponibili
             */
            $order = new Order($dataOrder);
            $ticket = Ticket::find($ticket_id[$i]);
            $order = $order->ticket()->associate($ticket);
            $order = $order->payment()->associate($payment);
            $payment->feedback()->associate($feedback);
            $payment->orders()->save($order);
            $payment->total += $order->quantity * $ticket->price;
            $payment->save();

            if(Input::get('remove_ticket') == "yes")
                $ticket->decrement('quantity', $order->quantity);
        }


        if(Input::get('send_notification') == "yes"){

            $data['payment'] = serialize($payment);
            $data['user'] = serialize($user);
            $data['feedback'] = serialize($feedback);
            Mail::queue('emails.newpayment', $data, function($message) use ($payment,$user)
            {
                    $message->to($user->email)->subject('Your order is placed #'.$payment->id_payment );
            });
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

        $payment = Payment::with('user','orders.ticket.match')->findOrFail($id);
        if($payment->visited == false)
            $payment->markAsVisited();
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
        $matches = DB::table('events as m')
            ->select('id_event',DB::raw('CONCAT(t1.name," - ",t2.name," (",DATE_FORMAT(date,"%d/%m/%Y"),")") AS label_match'))
            ->join('teams as t1','t1.id_team','=','m.home_id')
            ->join('teams as t2','t2.id_team','=','m.guest_id')
            ->orderBy('date','desc')
            ->lists('label_match','id_event');

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

        $pay_date = Input::get('pay_date');
        $arrTicketID = Input::get('ticket_id');
        $arrMatchID = Input::get('event_id');
        $arrQuantity = Input::get('quantity');

        if(!strtotime($pay_date))
            return Redirect::back()->withErrors('Date Error');

        $pay_date = date('Y-m-d',strtotime($pay_date));

		$validator = Validator::make($data = ['pay_date' => $pay_date], Payment::$rules_update);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator);
		}

        //aggiorno ogni order
        $i=0;
        //per aggiornare il total dell'order
        $total = 0;
        foreach($payment->orders as $order){
            if(Input::get('update_ticketQuantity') == "yes" && $arrQuantity[$i] != $order->quantity){ //se devo aggiornare quantita di ticket
                $order->ticket->quantity += $order->quantity - $arrQuantity[$i];
                $order->ticket->save();
            }
            $total += $arrQuantity[$i] * $order->ticket->price;
            $order->quantity = $arrQuantity[$i];
            $order->ticket_id = $arrTicketID[$i];
            $order->save();
            $i++;
        }

        $data['total'] = $total;
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

    public function search(){
        //$payments = Payment::orderBy('pay_date','desc')->with('orders','user')->where('firstname','LIKE','%'.Input::get('firstname').'$')->paginate(3);
        return View::make($this->viewFolder.'payments.index', compact('payments'));
    }

    /**
     * @param $payment_id il payment a cui si sta aggiungendo il codice tracking
     *
     * @return \Illuminate\View\View
     */
    public function addTrackingCode($payment_id){
        $payment = Payment::find($payment_id);
        return View::make($this->viewFolder.'payments.trackingcode',compact('payment'));
    }

    /**
     * @param $payment_id Il codice payment a cui si sta modificando il tracking code
     */
    public function updateTrackingCode($payment_id){

        //modifico tracking code e lo salvo
        $payment = Payment::with('user','orders.ticket')->findOrFail($payment_id);
        $payment->trackingcode = Input::get('trackingcode');
        $payment->save();

        //TODO: controllo se e a chi devo inviare avviso

        return Redirect::back()->with('success','Codice Tracking Modificato/Inserito con successo !');
    }

    /**
     * Dato il pagamento rileva tutti i cambi nomi da fare
     * (solo se nel pagamento sono compresi biglietti per partite di calcio italiane)
     *
     * @param $payment_id
     *
     * @return \Illuminate\View\View
     */
    public function showConsumers($payment_id){
        $payment = Payment::with('orders.consumers','orders.ticket')->find($payment_id);

        return View::make($this->viewFolder.'payments.consumers',compact('payment'));
    }

    /**
     * Segnala il pagamento come gia pagato
     *
     * @param $payment_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsPaid($payment_id){
        Payment::find($payment_id)->markAsPaid();

        return Redirect::back()->with('success','Payment #'.$payment_id.' marked as Paid !');
    }
    /**
     * Segnala il pagamento come NON pagato
     *
     * @param $payment_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsUnpaid($payment_id){
        Payment::find($payment_id)->markAsUnpaid();
        return Redirect::back()->with('success','Payment #'.$payment_id.' marked as <b>Not paid </b>!');
    }
}

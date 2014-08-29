<?php

class PaymentsController extends \BaseController {

	/**
	 * Display a listing of payments
	 *
	 * @return Response
	 */
	public function index()
	{
		$payments = Payment::all();

		return View::make('payments.index', compact('payments'));
	}

	/**
	 * Show the form for creating a new payment
	 *
	 * @return Response
	 */
	public function create()
	{
        $matches = Match::select('id_match', DB::raw('CONCAT(home_team, " - ", guest_team, " (", DATE_FORMAT(date,"%d/%m/%Y") ," )") AS label_match'))->take(10)
            ->orderBy('date')
            ->lists('label_match', 'id_match');

        $users = User::select('id_user',DB::raw('CONCAT(firstname, " ", lastname) AS name'))->lists('name','id_user');

		return View::make('payments.create',compact('matches','users'));
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
            'pay_date' => date("Y-m-d", strtotime($pay_date)),
            'total' => '200'
        ];

        $validatePayment =  Validator::make($data = $dataPayment, Payment::$rules);
        if ($validatePayment->fails())
        {
            return Redirect::back()->withErrors($validatePayment);
        }


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

            $order = new Order($dataOrder);
            $ticket = Ticket::find($ticket_id[$i]);
            $order = $order->ticket()->associate($ticket);
            $order = $order->payment()->associate($payment);
            $payment->orders()->save($order);
        }

		return Redirect::route('payments.index');
	}

	/**
	 * Display the specified payment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$payment = Payment::findOrFail($id);

		return View::make('payments.show', compact('payment'));
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

		return View::make('payments.edit', compact('payment'));
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

		return Redirect::route('payments.index');
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

		return Redirect::route('payments.index');
	}

}

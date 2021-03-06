<?php
namespace Backend\Controller;

use Backend\Model\Payment;
use Backend\Controller\UPSCourrier;
use View;

class ShipmentsController extends BaseController {

	/**
	 * Visualizzo tutti i pagamenti in attesa di shipment
     * trackingcode = null && status = "APPROVED"
	 *
	 * @return Response
	 */
	public function waitShipment()
	{
        $shipments = Payment::with('user')
            ->whereNull('trackingcode')
            ->where('status','=','APPROVED')
            ->orderBy('updated_at','desc')
            ->paginate();

		return View::make($this->viewFolder.'shipments.waiting', compact('shipments'));
	}

	/**
	 * Ritorna tutti i shipment spediti
	 *
	 * @return Response
	 */
	public function trackShipment()
	{
        $shipments = Payment::with('user')
            ->whereNotNull('trackingcode')
            ->where('status','=','APPROVED')
            ->orderBy('updated_at','desc')
            ->paginate();

        return View::make($this->viewFolder.'shipments.track',compact('shipments'));
	}

	/**
	 * Store a newly created shipment in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Shipment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Shipment::create($data);

		return Redirect::route($this->viewFolder.'shipments.index');
	}

	/**
	 * Display the specified shipment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$shipment = Shipment::findOrFail($id);

		return View::make($this->viewFolder.'shipments.show', compact('shipment'));
	}

	/**
	 * Show the form for editing the specified shipment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$shipment = Shipment::find($id);

		return View::make($this->viewFolder.'shipments.edit', compact('shipment'));
	}

	/**
	 * Update the specified shipment in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$shipment = Shipment::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Shipment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$shipment->update($data);

		return Redirect::route($this->viewFolder.'shipments.index');
	}

	/**
	 * Remove the specified shipment from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Shipment::destroy($id);

		return Redirect::route($this->viewFolder.'shipments.index');
	}

}

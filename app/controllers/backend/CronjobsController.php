<?php

namespace Backend\Controller;

use Backend\Model\Cronjob;
use Backend\Model\JobHistory;
use Illuminate\Support\Traits\MacroableTrait;
use View;
use Redirect;

class CronjobsController extends BaseController {

	/**
	 * Display a listing of cronjobs
	 *
	 * @return Response
	 */
	public function index()
	{
		$cronjobs = JobHistory::with('cronjob')->orderBy('last_execution','desc')->paginate(15);

		return View::make($this->viewFolder.'cronjobs.index', compact('cronjobs'));
	}

	/**
	 * Display the specified cronjob.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$cronjob = Cronjob::findOrFail($id);

		return View::make($this->viewFolder.'cronjobs.show', compact('cronjob'));
	}


	/**
	 * Remove the specified cronjob from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Cronjob::destroy($id);

		return Redirect::route($this->viewFolder.'cronjobs.index');
	}

}

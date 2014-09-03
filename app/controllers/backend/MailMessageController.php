<?php
namespace Backend\Controller;

use Backend\Model\MailMessage;
use View;
use Validator;
use Input;
use Redirect;
use Mail;


class MailMessageController extends BaseController {

	/**
	 * Display a listing of mails
	 *
	 * @return Response
	 */
	public function index()
	{
		$mails = MailMessage::all();

		return View::make($this->viewFolder.'mails.index', compact('mails'));
	}

	/**
	 * Show the form for creating a new mail
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make($this->viewFolder.'mails.create');
	}

	/**
	 * Store a newly created mail in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), MailMessage::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Mail::create($data);

		return Redirect::route('admin.mails.index');
	}

	/**
	 * Display the specified mail.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$mail = MailMessage::findOrFail($id);

		return View::make($this->viewFolder.'mails.show', compact('mail'));
	}

	/**
	 * Remove the specified mail from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        MailMessage::destroy($id);

		return Redirect::route('admin.mails.index');
	}

    public function contactus(){

    }
}

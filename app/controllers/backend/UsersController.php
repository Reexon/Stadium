<?php
namespace Backend\Controller;

use View;
use Validator;
use Redirect;
use Input;
use Backend\Model\User;
use Hash;
use Auth;
use Session;
use Response;

class UsersController extends BaseController {


	/**
	 * Display a listing of users
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::paginate();

		return View::make($this->viewFolder.'users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new user
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make($this->viewFolder.'users.create');
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        /**
         * TODO: Bisogna gestire il caso in cui si registra un utente
         * che pero' precedentemente ha effettuato acquisti.
         * si tratta di aggiornare l'user esistente, ma bisogna fare attenzione nel caso in cui
         * sia un'altra persona a utilizzare la mail di un'altra persona.
         */
        $validator = Validator::make($data = Input::all(), User::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        //dei dati validati, converto la password che deve essere in Hash
        $data['password'] = Hash::make(Input::get('password'));

		User::create($data);

		return Redirect::route('admin.users.index')->with('success','User Created Succesfully');
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::findOrFail($id);

		return View::make($this->viewFolder.'users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);

		return View::make($this->viewFolder.'users.edit', compact('user'));
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);

		$validator = Validator::make($data = Input::all(), ['firstname' => 'required',
                                                            'lastname' => 'required',
                                                             'email' => 'required|email']);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$user->update($data);

		return Redirect::route('admin.users.index')->with('success','User Updated Succesfully');
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::destroy($id);

		return Redirect::route('admin.users.index');
	}

    /**
     * Make Authentication of user
     *
     * @return Response
     */
    public function login(){
        if (Auth::attempt(['email'=>Input::get('email'), 'password'=>Input::get('password')])) {

            if(Auth::user()->isAdmin)
                return Redirect::to('admin/dashboard')->with('message', 'You are now logged in!');

            return Redirect::to('/')->with('message', 'You are now logged in!');
        } else {
            return Redirect::to('login')
                ->withErrors('Your username/password combination was incorrect')
                ->withInput();
        }
    }

    /**
     * Make De-Authentication of user
     *
     * @return Response
     */
    public function logout(){
        Auth::logout();
        return Redirect::to('login')->with('message', 'Your are now logged out!');
    }

    public function search(){
        //check if its our form
        if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( Input::all() );
        }

        $firstname = Input::get( 'firstname' );
        $lastname = Input::get( 'lastname' );
        $email = Input::get( 'email' );

        $response = User::where('firstname','LIKE','%'.$firstname.'%')
                                ->where('lastname','LIKE','%'.$lastname.'%')
                                ->where('email','LIKE','%'.$email.'%')->get();

        return Response::json( $response );
    }

}

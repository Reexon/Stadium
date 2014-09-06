<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/','Frontend\Controller\MatchesController@index');
Route::get('contact',function(){return View::make('contact');});
Route::get('/match/info/{id_match}','Frontend\Controller\MatchesController@info');
Route::post('match/signup/{id_match}','Frontend\Controller\MatchesController@signup');
/*
 * Gestione del carrello dei ticket
 */
Route::post('cart/update',function(){

    //carrello attuale utente
    $userCart = Session::get('cart');

    //valori dal form
    $ticket_id = Input::get('ticket_id');
    $quantity = Input::get('quantity');

    $postData = [Input::get('ticket_id') => Input::get('quantity')];

    if($userCart != null){//se il carrello gia esiste

        if(array_key_exists($ticket_id,$userCart)){
            $userCart[$ticket_id] += $quantity;

        }else{ //ticket nuovo lo aggiungo
            $userCart[$ticket_id] = $quantity;
        }

    }else //il carrello non esiste
        $userCart = $postData;

    //sostituisco con il nuovo carrello
    Session::put('cart',$userCart);

    return Redirect::back();
});

/*
 * Cart Manager
 */
Route::get('cart/clear','Frontend\Controller\CartController@clear');
Route::get('cart/info','Frontend\Controller\CartController@info');

Route::post('users/login','Backend\Controller\UsersController@login');

/*
 * Registration manager
 */
Route::get('register',function(){ return View::make('backend.users.register');});
Route::post('register','Backend\Controller\UsersController@store');

/*
 * Login / Logout
 */
Route::get('login',function(){return View::make('backend.users.login');});
Route::post('login','Backend\Controller\UsersController@login');
Route::get('logout','Backend\Controller\UsersController@logout');

/*
 * Invio Mail (contact us)
 */

Route::post('contact/send','Backend\Controller\MailMessageController@contactus');

/*
 * Gestisco tutti i route per l'admin, che hanno il prefisso /admin/*
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth|admin','namespace' => 'Backend\Controller'), function() {
    /*
     *
     */

    Route::get('dashboard','DashboardController@index');

    /*
     * Matches
     */

    //restituzione ticket per una determinata paritta (creazione payent)
    Route::post('matches/findTicket','MatchesController@findTicket');
    Route::resource('matches', 'MatchesController');

    /*
     * Tickets
     */
    Route::get('tickets/selled/{id_match}', 'TicketsController@selledForMatch');
    Route::get('tickets/create/{id}', 'TicketsController@create');
    Route::resource('tickets', 'TicketsController');

    /*
     * Users
     */

    Route::post('users/search','UsersController@search');
    Route::resource('users', 'UsersController');

    /*
     * Payments
     */
    Route::get('payments/search','PaymentsController@search');
    Route::resource('payments', 'PaymentsController');

    /*
     * MailMessage
     */

    Route::resource('mails', 'MailMessageController',[
                                                'only' => ['index', 'show','create']
                                                ]
    );


    Route::resource('teams', 'TeamsController');

    /*
     * Richeista ajax , che restituisce numero di ticket disponibili in base al ticket_id
     */
    Route::post('tickets/findQuantity','TicketsController@findQuantity');
});

Route::group(array('prefix' => 'user', 'before' => 'auth','namespace' => 'Frontend\Controller'), function() {
    Route::get('payments','UsersController@payments');
    Route::get('profile','UsersController@profile');
    Route::post('profile/update','UsersController@update');
});

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

/*
 * Gestione del carrello dei ticket
 */
Route::post('cart/update',function(){


    $userCart = Session::get('cart');

    $postData = ['ticket_id' => Input::get('ticket_id'),
             'quantity' => Input::get('quantity')];

    if($userCart != null){//se il carrello gia esiste
        
        if(array_key_exists($postData['ticket_id'],$userCart)){
            $userCart[$postData['ticket_id']] += $postData['quantity'];
        }else{ //ticket nuovo lo aggiungo
            $userCart[$postData['ticket_id']] = $postData['quantity'];
        }
    }else //il carrello non esiste
        $userCart = $postData;

    //sostituisco con il nuovo carrello
    Session::put('cart',$userCart);

    return Redirect::back();
});
Route::get('cart/info','CartController@show');
Route::post('users/login','Backend\Controller\UsersController@login');
Route::get('login',function(){return View::make('backend.users.login');});
Route::post('login','Backend\Controller\UsersController@login');
Route::get('logout','Backend\Controller\UsersController@logout');
Route::get('register',function(){return View::make('users.register');});


/*
 * Gestisco tutti i route per l'admin, che hanno il prefisso /admin/*
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth','namespace' => 'Backend\Controller'), function() {
    /*
     *
     */

    Route::get('/',function(){
        return View::make('backend.users.login');
    });

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

    Route::resource('payments', 'PaymentsController');

    /*
     * MailMessage
     */

    Route::resource('mails', 'MailMessageController',[
                                                'only' => ['index', 'show','create']
                                                ]
    );
});
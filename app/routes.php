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

Route::get('/', function()
{
	return View::make('hello');
});

Route::post('users/login','Backend\Controller\UsersController@login');
Route::get('login',function(){return View::make('users.login');});
Route::post('login','Backend\Controller\UsersController@login');
Route::get('logout','Backend\Controller\UsersController@logout');
Route::get('register',function(){return View::make('users.register');});


Route::group(array('prefix' => 'admin', 'before' => 'auth','namespace' => 'Backend\Controller'), function() {
    /*
     *
     */

    Route::get('/',function(){
        return View::make('users.login');
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
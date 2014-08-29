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
Route::post('users/login','UsersController@login');
Route::get('users/login',function(){return View::make('users.login');});
Route::get('users/logout','UsersController@logout');
Route::get('users/register',function(){return View::make('users.register');});
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
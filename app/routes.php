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
	return View::make('users.login');
});

Route::resource('matches', 'MatchesController');
Route::resource('tickets', 'TicketsController');
Route::post('users/login','UsersController@login');
Route::get('users/login',function(){
    return View::make('users.login');
});
Route::post('users/logout','UsersController@logout');
Route::get('users/register',function(){
    return View::make('users.register');
});
//not working ?
Route::resource('users', 'UsersController');
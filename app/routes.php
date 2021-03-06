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

Route::get('task/courrier/run',function(){
    Artisan::call('shipments:update');
});
Route::get('/track','Backend\Controller\UPSCourrier@start');

Route::get('/',function(){
    return View::make('frontend.index');
});

Route::get('contact',function(){return View::make('contact');});

/*
 * Eventi di Tipo Match
 */
//Route::get('match/info/{id_event}','Frontend\Controller\MatchesController@info');
Route::get('event/info/{id_category}/{id_event}','Frontend\Controller\MatchesController@info');
Route::post('match/signup/{id_event}','Frontend\Controller\MatchesController@signup');

/*
 * Cron Jobs
 */
Route::resource('cronjobs', 'Backend\Controller\CronjobsController');
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

    return Redirect::back()->with('success','Tickets Added To Cart !');
});

/*
 * Cart Manager
 */
Route::get('cart/clear','Frontend\Controller\CartController@clear');
Route::get('cart/show','Frontend\Controller\CartController@show');
Route::get('cart/personalInfo','Frontend\Controller\CartController@personalInfo');
Route::post('cart/review','Frontend\Controller\CartController@review');
Route::any('cart/buy','Frontend\Controller\CartController@buy');
Route::post('cart/consumerInfo','Frontend\Controller\CartController@consumerAnagSave');
Route::get('cart/consumerInfo','Frontend\Controller\CartController@consumerAnag');
//il consorzio invia i dati a questa pagina in modalità post, da non cambiare
Route::post('cart/receipt','Frontend\Controller\CartController@receipt');
//dopo il receipt si viene spediti a questa pagina
Route::get('cart/result','Frontend\Controller\CartController@result');
//nel caso in cui non si riesca a raggiungere la pagina receipt, questa pagina verrà richiamata
Route::get('cart/error','Frontend\Controller\CartController@error');
Route::post('users/login','Backend\Controller\UsersController@login');

/*
 * Registration manager
 */
Route::get('register',function(){ return View::make('backend.users.register');});

Route::post('register','Backend\Controller\UsersController@store');

/*
 * Login / Logout
 */
Route::get('login',function(){return View::make('frontend.user.login');});
Route::post('login','Backend\Controller\UsersController@login');
Route::get('logout','Backend\Controller\UsersController@logout');

/*
 * Invio Mail (contact us)
 */

Route::post('contact/send','Backend\Controller\MailMessageController@contactus');

Route::get('feedbacks/create/{UUID}','Frontend\Controller\FeedbacksController@create');
Route::post('feedbacks','Frontend\Controller\FeedbacksController@submit');
/*
 * Gestisco tutti i route per l'admin, che hanno il prefisso /admin/*
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth|admin','namespace' => 'Backend\Controller'), function() {
    /*
     * AJAX Richiesta SubCategoreis
     */
    Route::post('categories/findSubCategories','CategoriesController@findSubCategories');
    /*
     * DashBoard
     */

    Route::get('dashboard','DashboardController@index');

    /*
     * Payment Shipment Tracking
     */
    Route::get('shipments/waiting','ShipmentsController@waitShipment');
    Route::get('shipments/tracking','ShipmentsController@trackShipment');
    /*
     * Matches
     */

    //restituzione ticket per una determinata paritta (creazione payent)
    Route::post('matches/findTicket','MatchesController@findTicket');
    Route::resource('matches', 'MatchesController');

    /*
     * Tickets
     */

    Route::get('tickets/create/{category_id?}/{id?}', 'TicketsController@create');
    Route::get('tickets/{category_id}/{id}/edit','TicketsController@edit');
    Route::resource('tickets', 'TicketsController');

    /*
     * Artists
     */
    Route::resource('artists', 'ArtistsController');

    /*
     * Concerts
     */
    Route::resource('concerts', 'ConcertsController');

    /*
     * Users
     */

    Route::post('users/search','UsersController@search');
    Route::resource('users', 'UsersController');

    /*
     * Payments
     */
    Route::get('payments/search','PaymentsController@search');
    Route::get('payments/create/{category_id}/{event_id?}','PaymentsController@create');
    Route::get('payments/category/{category_id}','PaymentsController@showCategory');
    Route::get('payments/{event_id}/trackingCode','PaymentsController@addTrackingCode');
    Route::post('payments/{event_id}/updateTrackingCode','PaymentsController@updateTrackingCode');
    //per trovare i cambi nominativi associati a quel payment
    Route::get('payments/{payment_id}/consumers','ConsumersController@show');
    //per markare un pagamento come gia pagato/non pagato
    Route::get('payments/{payment_id}/markAsPaid','PaymentsController@markAsPaid');
    Route::get('payments/{payment_id}/markAsUnpaid','PaymentsController@markAsUnpaid');

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

    /*
     * Match Subscriptions
     */
    Route::resource('MatchSubscriptions', 'MatchSubscriptionsController');

    /*
     * Gain
     */
    Route::get('gain','GainController@index');

    Route::resource('races','RacesController');
});


Route::get('user/payments/{id_payment}/consumers','Backend\Controller\PaymentsController@showConsumers');
Route::group(array('prefix' => 'user', 'before' => 'auth','namespace' => 'Frontend\Controller'), function() {
    Route::get('payments','UsersController@payments');
    Route::get('payments/{id_payment}','UsersController@paymentDetail');
    Route::get('profile','UsersController@profile');
    Route::post('profile/update','UsersController@update');
});

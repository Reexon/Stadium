<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 18/09/14
 * Time: 15:30
 */

namespace Backend\Controller;

use Backend\Model\Order;
use Backend\Model\Payment;
use Frontend\Model\MatchSubscription;
use DB;
use View;
use Paginator;

class DashboardController extends BaseController{

    public function index(){
        //pagamenti con success ma senza codice tracciamento
        Paginator::setPageName('pshippings');
        $shipPayments = Payment::with('user')->notShipped()->approved()->paginate();
        $data['shipCount'] = Payment::notShipped()->approved()->count();

        //pagamenti falliti o in errore
        Paginator::setPageName('pfailed');
        $data['failPayCount'] = Payment::notApproved()->whereNull('status','or')->count();
        $failPayments = Payment::notApproved()->whereNull('status','or')->paginate();

        //pagamenti non ancora guardati
        Paginator::setPageName('pnew');
        $data['newPayCount'] = Payment::notVisited()->count();
        $newPayments = Payment::notVisited()->paginate();

        return View::make($this->viewFolder."dashboard",compact('shipPayments','failPayments','newPayments','data'));

    }

} 
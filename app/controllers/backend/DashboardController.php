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
        $shipPayments = Payment::with('user')->whereNull('trackingcode')->where('status','=','APPROVED')->paginate();
        $data['shipCount'] = Payment::whereNull('trackingcode')->where('status','=','APPROVED')->count();

        //pagamenti falliti o in errore
        Paginator::setPageName('pfailed');
        $data['failPayCount'] = Payment::where('status','=','NOT APPROVED')->whereNull('status','or')->count();
        $failPayments = Payment::where('status','=','NOT APPROVED')->whereNull('status','or')->paginate();
        return View::make($this->viewFolder."dashboard",compact('shipPayments','failPayments','data'));
    }

} 
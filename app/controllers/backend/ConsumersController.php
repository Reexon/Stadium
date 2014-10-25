<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 30/09/14
 * Time: 14:57
 */

namespace Backend\Controller;


use Backend\Model\Payment;

use View;
class ConsumersController extends BaseController{
    /**
     * Dato il pagamento rileva tutti i cambi nomi da fare
     * (solo se nel pagamento sono compresi biglietti per partite di calcio italiane)
     *
     * @param $payment_id
     *
     * @return \Illuminate\View\View
     */
    public function show($payment_id){
        //$payment = Payment::with('orders.consumers')->find($payment_id);
        $payment = Payment::with('orders.consumers','orders.ticket.event')->find($payment_id);
        return View::make($this->viewFolder.'payments.consumers',compact('payment'));
    }

}
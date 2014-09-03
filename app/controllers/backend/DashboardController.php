<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 03/09/14
 * Time: 15:57
 */

namespace Backend\Controller;

use Backend\Model\Order;
use Backend\Model\Payment;
use DB;
use Frontend\Model\MatchSubscription;
use View;

class DashboardController extends BaseController{

    public function index(){

        $from = time()-(60*60*24*7);
        $order_count = Payment::where('pay_date','>',$from)->count();
        $ticket_sell = Order::where('created_at','>',$from)->sum('quantity');
        $total_amount = Payment::where('pay_date','>',$from)->sum('total');

        $payments = Payment::orderBy('pay_date','desc')->take(10)->get();
        $data = ['orderCount' => $order_count,
                'ticketCount'   => $ticket_sell,
                'total_amount'  => $total_amount];


        $tickets =
            Order::select('tickets.*','matches.*',DB::raw('SUM(orders.quantity) as qty_selled'))
            ->join('tickets','ticket_id','=','id_ticket')
            ->join('matches','match_id','=','id_match')
            ->groupBy('ticket_id')
            ->get();

        $subscriptions = MatchSubscription::select('matches.*',DB::raw('COUNT(*) as qty'))
            ->join('matches','match_id','=','id_match')
            ->groupBy('match_id')
            ->get();

        return View::make($this->viewFolder.'dashboard',compact('data','payments','tickets','subscriptions'));
    }
} 
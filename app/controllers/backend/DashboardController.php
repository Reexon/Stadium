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

        $totalArray = DB::select('SELECT id_match,CONCAT(home," - ",guest) as label_match,SUM(total) as total
                                    FROM (
                                        SELECT t1.name as home,t2.name as guest,id_match,total FROM payments
                                        INNER JOIN orders ON payment_id = id_payment
                                        INNER JOIN tickets ON id_ticket = ticket_id
                                        INNER JOIN matches ON match_id = id_match
                                        INNER JOIN teams t1 ON t1.id_team = home_id
                                        INNER JOIN teams t2 ON t2.id_team = guest_id
                                        GROUP BY id_payment
                                        )as t
                                    GROUP BY id_match');


        $payments = Payment::orderBy('pay_date','desc')->take(10)->get();
        $data = ['orderCount' => $order_count,
                'ticketCount'   => $ticket_sell,
                'total_amount'  => $total_amount];


        $tickets =
            Order::select('tickets.*','m.*',DB::raw('SUM(orders.quantity) as qty_selled'),DB::raw('CONCAT(t1.name," - ",t2.name) as label_match'))
            ->join('tickets','ticket_id','=','id_ticket')
            ->join('matches as m','match_id','=','id_match')
            ->join('teams as t1','t1.id_team','=','m.home_id')
            ->join('teams as t2','t2.id_team','=','m.guest_id')
            ->groupBy('ticket_id')
            ->get();

        $subscriptions = MatchSubscription::select('m.*',DB::raw('COUNT(*) as qty'),DB::raw('CONCAT(t1.name," - ",t2.name) as label_match'))
            ->join('matches as m','match_id','=','id_match')
            ->join('teams as t1','t1.id_team','=','m.home_id')
            ->join('teams as t2','t2.id_team','=','m.guest_id')
            ->groupBy('match_id')
            ->get();

        return View::make($this->viewFolder.'dashboard',compact('data','payments','tickets','subscriptions','totalArray'));
    }
} 
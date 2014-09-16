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
use Paginator;

class DashboardController extends BaseController{

    public function index(){
        $order_count = Payment::where('pay_date','>',DB::raw('DATE_SUB(curdate(), INTERVAL 1 WEEK)'))->count();
        $ticket_sell = Order::where('created_at','>',DB::raw('DATE_SUB(curdate(), INTERVAL 1 WEEK)'))->sum('quantity');
        $total_amount = Payment::where('pay_date','>',DB::raw('DATE_SUB(curdate(), INTERVAL 1 WEEK)'))->sum('total');

        //TODO: Pagination dei amount
        //TODO: bisogna selezionare solo i amount dell'ultima settimana o mese
        $totalArray = DB::select('SELECT id_event,CONCAT(home," - ",guest) as label_match,SUM(total) as total
                                    FROM (
                                        SELECT t1.name as home,t2.name as guest,id_event,total FROM payments
                                        INNER JOIN orders ON payment_id = id_payment
                                        INNER JOIN tickets ON id_ticket = ticket_id
                                        INNER JOIN events ON event_id = id_event
                                        INNER JOIN teams t1 ON t1.id_team = home_id
                                        INNER JOIN teams t2 ON t2.id_team = guest_id
                                        GROUP BY id_payment
                                        )as t
                                    GROUP BY id_event LIMIT 50');


        Paginator::setPageName('ppayments');
        $payments = Payment::with('user')->orderBy('pay_date','desc')->limit(50)->paginate();

        $data = ['orderCount' => $order_count,
                'ticketCount'   => $ticket_sell,
                'total_amount'  => $total_amount];


        Paginator::setPageName('ptickets');
        $tickets =
            Order::select('tickets.*','m.*',DB::raw('SUM(orders.quantity) as qty_selled'),DB::raw('CONCAT(t1.name," - ",t2.name) as label_match'))
            ->join('tickets','ticket_id','=','id_ticket')
            ->join('events as m','event_id','=','id_event')
            ->join('teams as t1','t1.id_team','=','m.home_id')
            ->join('teams as t2','t2.id_team','=','m.guest_id')
            ->groupBy('ticket_id')
            ->limit(50)
            ->paginate();

        Paginator::setPageName('psubscribers');
        $subscriptions = MatchSubscription::select('m.*',DB::raw('COUNT(*) as qty'),DB::raw('CONCAT(t1.name," - ",t2.name) as label_match'))
            ->join('events as m','event_id','=','id_event')
            ->join('teams as t1','t1.id_team','=','m.home_id')
            ->join('teams as t2','t2.id_team','=','m.guest_id')
            ->groupBy('event_id')
            ->limit(50)
            ->paginate();

        return View::make($this->viewFolder.'dashboard',compact('data','payments','tickets','subscriptions','totalArray'));
    }
} 
<?php

namespace Backend\Controller;

use View;
use DB;

class GainController extends BaseController{

    public function index(){

        $monthGain = $this->monthGain();
        $yearGain = $this->yearGain();
        return View::make($this->viewFolder.'gain.index',compact('monthGain','yearGain'));
    }

    private function yearGain(){
        return DB::table('payments')->select(
            DB::raw("YEAR(pay_date) as year"),
            DB::raw('SUM(total) as total')
        )
            ->groupBy('year')
            ->get();
    }
    private function monthGain(){
        /*
         * SELECT YEAR(pay_date) as year,
         *      DATE_FORMAT(pay_date,'%M') as month,
         *      SUM(total) as total
         * FROM `payments`
         * GROUP BY MONTH(pay_date)
         */
        return DB::table('payments')->select(
            DB::raw("YEAR(pay_date) as year"),
            DB::raw("DATE_FORMAT(pay_date,'%M') as month"),
            DB::raw('SUM(total) as total')
        )
            ->groupBy(DB::raw('MONTH(pay_date)'))
            ->get();
    }
    private function gainEachMach(){
        /* Seleziono il guadagno di ogni match per visualizzarlo nel grafico
         * -------------
         * SELECT id_event,CONCAT(h.name,' - ',g.name)as label_match,SUM(total)
         * FROM payments
         * INNER JOIN orders ON id_payment = payment_id
         * INNER JOIN tickets ON id_ticket = ticket_id
         * INNER JOIN matches ON id_event = match_id
         * INNER JOIN teams h ON h.id_team = home_id
         * INNER JOIN teams g ON g.id_team = guest_id group by id_event
         */
        $gain=DB::table('payments')->select('id_event',
            DB::raw('CONCAT(h.name,\' - \',g.name)as label_match'),
            DB::raw('SUM(total) as total'))
            ->join('orders','id_payment','=','payment_id')
            ->join('tickets','id_ticket','=','ticket_id')
            ->join('events','id_event','=','event_id')
            ->join('teams AS h','h.id_team','=','home_id')
            ->join('teams AS g','g.id_team','=','guest_id')
            ->groupBy('id_event')
            ->get();
    }
} 
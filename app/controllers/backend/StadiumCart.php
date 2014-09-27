<?php
namespace Backend\Controller;

use Session;
use Backend\Model\Ticket;
use Redirect;
use Backend\Model\Match;
class StadiumCart {

    /**
     * Calcola il prezzo totale del carrello dell'user
     *
     * @return int
     */
    public static function total(){
        $cart = Session::get('cart');
        $total = 0;

        foreach($cart as $ticket_id => $quantity){
            $ticket = Ticket::find($ticket_id);
            $total += $ticket->price * $quantity;
        }
        return $total;
    }

    /**
     * Durante l'inserimento dei nominativi per il cambio nome, il form invia i dati nel seguente formato
     * consumer[ticket_id]
     *       0  =>   15
     *       1  =>   18
     * consumer[firstname]
     *      0   =>   Osvaldo
     *      1   =>   Franco
     * ...
     *
     * Dopo questo metodo il risultato sarà
     *
     *      array(
     *            'ticket_id' =>  15,
     *            'firstname' => 'Osvaldo
     *          )
     *      array(
     *            'ticket_id'   => 18,
     *            'firstname'   => Franco,
     *          )
     */
    public static function arrangeConsumerArray($consumers){
        //input name, provenienti dal form con le informazioni dei utenti finali (cambio-nominativo)
        $fields = ['born_date','born_location','res_prov','res_via','res_cap','res_com','ticket_id'];
        $tot_consumer = count($consumers['born_date']);

        $session_consumer = [];
        for($i = 0 ; $i < $tot_consumer; $i++){//per ogni customer
            $array = [];
            foreach($fields as $field)//prelevo i dati e li inserisco in modo ordinato (key-value)
                $array[$field] = $consumers[$field][$i];
            $session_consumer[] = $array;
        }
        return $session_consumer;
    }

    /**
     * Semplicemente conto ogni tipo di ticket, quanti nominativi ha associati.
     *
     * ticket_id(type)  => qty
     *     435          =>  5
     *     132          =>  4
     *
     * Esempio, se l'utente acquista 5 biglietti (Milan) e 4 Biglietti (Inter), ci devono
     * essere 5 nominativi per milan e 4 nominativi per inter, i numeri devono perforza concidere
     */
    private static function howManyTicketType($consumersData){
        //leggo quanti ticket sono stati assegnati durante l'inserimento dei consumer
        $ticket = [];
        foreach ($consumersData as $consumer){
            //se la chiave gia esiste nell'array, lo incremento, senno setto a 1 xk è nuovo
            if(array_key_exists($consumer['ticket_id'],$ticket))
                $ticket[$consumer['ticket_id']] +=1;
            else
                $ticket[$consumer['ticket_id']] =1;
        }
        return $ticket;
    }

    /**
     * Controlla se la quantità dei biglietti dei nominativi corrisponde con i biglietti del carrello
     *
     * @param $consumersData
     *
     * @return bool
     */
    public static function checkConsumerCountError($consumersData){

        $ticket = self::howManyTicketType($consumersData);

        $cart = Session::get('cart');
        foreach($cart as $ticket_id => $quantity){//per ogni ticket nel carrello
            if(array_key_exists($ticket_id,$ticket)){
                if($ticket[$ticket_id] != $quantity)//prima di controllare se i numeri corrispondono, devo prima controllare che la chiave esista
                    return false;
            }else
                return false;
        }

        return true;
    }

    /**
     * Controlla se nel carrello sono presenti ticket di calcio
     *
     * @return bool
     */
    public static function hasFootballTickets(){
        $cart = Session::get('cart');
        if($cart != null){
            foreach($cart as $ticket_id => $quantity){
                $ticket_id_list[] = $ticket_id;
                $item = Ticket::find($ticket_id);
                if($item->category_id == Match::$football){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Ritorna un'array contenente i tipi di ticket(ticket_id) nel carrello
     *
     * @return array
     */
    public static function arrayTicketsID(){
        $cart = Session::get('cart');
        $ticketsID=[];
        if($cart != null){
            foreach($cart as $ticket_id => $quantity){
                $ticketsID[] = $ticket_id;
            }
        }

        return $ticketsID;
    }

    /**
     * Numero di biglietti per calcio
     *
     * @return int
     */
    public static function footballTicketsCount(){
        $football_tickets = 0;
        $cart = Session::get('cart');
        if($cart != null){
            foreach($cart as $ticket_id => $quantity){
                $item = Ticket::find($ticket_id);
                if($item->category_id == Match::$football){
                    $football_tickets +=  $quantity; //salvo quanti ticket di calcio ha nel carrello
                }
            }
        }
        return $football_tickets;
    }
}

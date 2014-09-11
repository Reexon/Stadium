<?php

namespace Frontend\Controller;

use View;
use Session;
use Backend\Model\Ticket;
use Input;
class CartController extends BaseController{

    public function info(){
        $cart = Session::get('cart');


        //TODO Da migliorare assolutamente, dal carrello produce una tabella riepilogativa.
        $cartItems = [];
        if($cart != null){
            foreach($cart as $ticket_id => $quantity){
                $item = Ticket::find($ticket_id)->toArray();
                $item['buy_quantity'] = $quantity;
                $cartItems[]=$item;
            }
        }

        return View::make('infoCart',compact('cartItems','button'));
    }

    public function clear(){
        Session::forget('cart');
        return \Redirect::back();
    }

    public function refresh(){

    }

    public function checkout(){
        $cart = Session::get('cart');
        $button = $this->test();
        //TODO Da migliorare assolutamente, dal carrello produce una tabella riepilogativa.
        $cartItems = [];
        if($cart != null){
            foreach($cart as $ticket_id => $quantity){
                $item = Ticket::find($ticket_id)->toArray();
                $item['buy_quantity'] = $quantity;
                $cartItems[]=$item;
            }
        }
        return View::make('checkout',compact('cartItems','button'));
    }

    public function test(){
        //parametri da passare a triveneto

        $id=89025555;         //id di connessione
        $password="test";   //password di connessione

        $importo=123.45;      //importo da pagare
        $trackid="STDBI373Y873";      //id transazione

        $urlpositivo="http://stadium.local/cart/result";
        $urlnegativo="http://stadium.local/cart/result";
        $codicemoneta="978";  //euro
//stringa da passare al consorzio
        $data="id=$id&password=$password&action=1&langid=ITA&currencycode=$codicemoneta&amt=$importo&responseURL=$urlpositivo&errorURL=$urlnegativo&trackid=$trackid&udf1=AA&udf2=BB&udf3=CC&udf4=DD&udf5=EE";
    //inizio recupero valori dal sito del consorzio
        $curl_handle=curl_init();
        //curl_setopt($curl_handle,CURLOPT_URL,'https://www.constriv.com:443/cg/servlet/PaymentInitHTTPServlet');
        curl_setopt($curl_handle,CURLOPT_URL,'https://test4.constriv.com/cg301/servlet/PaymentInitHTTPServlet');
        curl_setopt($curl_handle, CURLOPT_VERBOSE, true);
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
        $buffer = curl_exec($curl_handle);

        if (empty($buffer))
        {
            return "gnagna".curl_error($curl_handle);
        }
        else
        {
            //print $buffer;
            $pezzi=explode(":",$buffer);
            $tid=$pezzi[0];
        curl_close($curl_handle);
//prepara il link per il pagamento
        if(strlen($tid)>0)
            return "<a href=\"".$pezzi[1].":".$pezzi[2]."?PaymentID=$tid\">Paga qui</a>";
        }

    }
    public function result(){
       dd(Input::all());
    }
} 
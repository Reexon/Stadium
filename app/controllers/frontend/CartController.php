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

        return View::make('infoCart',compact('cartItems'));
    }

    public function clear(){
        Session::forget('cart');
        return \Redirect::back();
    }

    public function refresh(){

    }

    public function checkout(){
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
        return View::make('checkout',compact('cartItems'));
    }

    /**
     * Effettua alcuni calcoli per poi indirizzare l'user alla pagina di pagamento
     */
    public function buy(){
        //parametri da passare a triveneto

        $id=89025555;           //id di connessione
        $password="test";       //password di connessione

        $importo=123.45;        //importo da pagare
        $trackid="STDBI373Y873";      //id transazione

        $urlpositivo="http://stadium.reexon.net/cart/receipt";
        $urlnegativo="http://stadium.reexon.net/cart/error";
        $codicemoneta="978";  //euro
        $data="id=$id&password=$password&action=4&langid=ITA&currencycode=$codicemoneta&amt=$importo&responseURL=$urlpositivo&errorURL=$urlnegativo&trackid=$trackid&udf1=AA&udf2=BB&udf3=CC&udf4=DD&udf5=EE";
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
            return curl_error($curl_handle);
        }
        else
        {
            //print $buffer;
            $url=explode(":",$buffer);
            $transaction_id=$url[0];
            curl_close($curl_handle);
            //prepara il link per il pagamento
            if(strlen($transaction_id)>0){
                $redirectURL = $url[1].":".$url[2]."?PaymentID=$transaction_id";
                echo "<meta http-equiv=\"refresh\" content=\"0;URL=$redirectURL\">";
            }
        }

    }
    public function result(){
       return View::make('result');
    }
    //in caso di errore
    public function error(){
        header("Access-Control-Allow-Origin: *");
        echo "AAA";
    }

    public function receipt(){
        header("Access-Control-Allow-Origin: *");
        $PayID=$_POST["paymentid"];
        $TransID=$_POST["tranid"];
        $ResCode=$_POST["result"];
        $AutCode=$_POST["auth"];
        $PosDate=$_POST["postdate"];
        $TrckID=$_POST["trackid"];
        $cardType =$_POST['cardtype'];
        $UD1=$_POST["udf1"];
        $UD2=$_POST["udf2"];
        $UD3=$_POST["udf3"];
        $UD4=$_POST["udf4"];
        $UD5=$_POST["udf5"];

        // Nell URL seguente inserire l'indirizzo corretto del proprio server
        $ReceiptURL="REDIRECT=http://stadium.reexon.net/cart/result?PaymentID=".$PayID."&TransID=".$TransID."&TrackID=".$TrckID."&postdate=".$PosDate."&resultcode=".$ResCode."&cardtype=".$cardType."&auth=".$AutCode;
        echo $ReceiptURL;
    }

    private function totalAmount(){

    }
} 
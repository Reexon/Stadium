<?php

namespace Frontend\Controller;

use Backend\Model\Match;
use Backend\Model\Order;
use Backend\Model\Payment;
use Backend\Model\User;
use Backend\Model\Consumer;
use View;
use Session;
use Backend\Model\Ticket;
use Input;
use Str;
use Backend\Model\Feedback;
use Auth;
use Mail;
use Validator;
use Redirect;
use Backend\Controller\StadiumCart;

class CartController extends BaseController{

    public function show(){
        $cart = Session::get('cart');

        //TODO Da migliorare assolutamente, dal carrello produce una tabella riepilogativa.
        $cartItems = [];
        $total_amount = 0;
        if($cart != null){
            foreach($cart as $ticket_id => $quantity){
                $item = Ticket::find($ticket_id)->toArray();
                $total_amount += $item['price'] * $quantity;
                $item['buy_quantity'] = $quantity;
                $cartItems[]=$item;
            }
        }

        return View::make($this->viewFolder.'cart.show',compact('cartItems','total_amount'));
    }

    /**
     * Riepilogo delle informazioni inserite, prima di procedere con il pagamento
     *
     * @return \Illuminate\View\View
     */
    public function review(){

        /*
         * devo controllare se nel form precedente sono stati compilati i campi obbligatori
         */
        $validator = Validator::make($data = Input::all(), [
            'firstname' => 'required|alpha|min:3',
            'lastname'  => 'required|alpha|min:3',
            'mobile'    => 'required|min:6',
            'email'     => 'required|email',
            'address'   => 'required|min:5',
            'city'      => 'required|min:3',
            'cap'       => 'required'
        ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        //-- fine controlli

        $cart = Session::get('cart');

        //TODO:Da migliorare assolutamente, dal carrello produce una tabella riepilogativa.
        $cartItems = [];
        $total_amount = 0;
        if($cart != null){
            foreach($cart as $ticket_id => $quantity){
                $item = Ticket::find($ticket_id)->toArray();
                $total_amount += $item['price'] * $quantity;
                $item['buy_quantity'] = $quantity;
                $cartItems[]=$item;
            }
        }

        /**
         * Indipendentemente se l'utente è loggato o no, memorizzo tutte le informazioni che ha inserito, questo perche:
         * - utente puo' gia essere loggato, ma vuole inserire dati diversi da quelli di registrazione
         * - utente non è loggato, e quindi deve inserire tutte le informazioni
         */

            $user = [
                'firstname' => Input::get('firstname'),
                'lastname'  => Input::get('lastname'),
                'mobile'    => Input::get('mobile'),
                'email'     => Input::get('email'),
                'alt_mobile'=> Input::get('alt_mobile'),
                'address'   => Input::get('address'),
                'city'      => Input::get('city'),
                'cap'       => Input::get('cap'),
            ];
            Session::put('user',$user);


        return View::make($this->viewFolder.'cart.review',compact('cartItems','total_amount'));
    }

    /**
     * Controllo se il carrello contiene dei biglietti di calcio
     * Se li contiene , devrò far inserire tanti nominativi quanti sono i ticket calcio
     */
    public function consumerAnag(){

        $hasFootballTicket = StadiumCart::hasFootballTickets();
        $total_ticket = StadiumCart::footballTicketsCount();
        $ticket_id_list= StadiumCart::arrayTicketsID();

        $selectOptionTickets= Ticket::whereIn('id_ticket',$ticket_id_list)->lists('label','id_ticket');

        if($hasFootballTicket){
            return View::make($this->viewFolder.'cart.consumerAnag',compact('total_ticket','selectOptionTickets'));
        }else
            return Redirect::to('cart/buy');

    }

    /**
     * Salva i dati per il cambio nome
     */
    public function consumerAnagSave(){
        $consumer = Input::get('consumer');

        $session_consummer = StadiumCart::arrangeConsumerArray($consumer);

        //Controllo Errori, eventualmente viene creato un errore.
        $bool = StadiumCart::checkConsumerCountError($session_consummer);

        if(!$bool)
            return Redirect::back()->withErrors('Problema sulle quantità');

        Session::set('consumers',$session_consummer);

        //TODO: Da Migliorare assolutamente
        $cart = Session::get('cart');
        $cartItems = [];
        $total_amount = 0;
        if($cart != null){
            foreach($cart as $ticket_id => $quantity){
                $item = Ticket::find($ticket_id)->toArray();
                $total_amount += $item['price'] * $quantity;
                $item['buy_quantity'] = $quantity;
                $cartItems[]=$item;
            }
        }
        return View::make($this->viewFolder.'cart.overview',compact('cartItems','total_amount'));
    }

    public function clear(){
        Session::forget('cart');
        return \Redirect::back();
    }

    public function refresh(){

    }

    /*
     * Pagina dove viene richiesto di inserire le informazioni personali
     * Prima di procedere al pagamento
     */
    public function personalInfo(){

        $cart = Session::get('cart');
        //TODO Da migliorare assolutamente, dal carrello produce una tabella riepilogativa.
        $cartItems = [];
        $total_amount = 0;
        if($cart != null){
            foreach($cart as $ticket_id => $quantity){
                $item = Ticket::find($ticket_id)->toArray();
                $total_amount += $item['price'] * $quantity;
                $item['buy_quantity'] = $quantity;
                $cartItems[]=$item;
            }
        }
        return View::make($this->viewFolder.'cart.personalInfo',compact('cartItems','total_amount'));
    }

    /**
     * Effettua alcuni calcoli per poi indirizzare l'user alla pagina di pagamento
     * Viene richiamata quando l'utente clicca "checkout"
     */
    public function buy(){

        $id=89025555;           //id di connessione
        $password="test";       //password di connessione

        //è necessario foramttare il totale in NNNNNN.NN
        $importo= number_format(StadiumCart::total(),2,'.','');//importo da pagare

        $trackid="STDRX".time();      //id transazione

        $urlpositivo="http://stadium.reexon.net/cart/receipt";
        $urlnegativo="http://stadium.reexon.net/cart/error";
        $codicemoneta="978";  //euro
        //prelevo i dati inseriti durante la fase acquisto
        $user = (object)Session::get('user');

        $data="id=$id
            &password=$password
            &action=4
            &langid=ITA
            &currencycode=$codicemoneta
            &amt=$importo
            &responseURL=$urlpositivo
            &errorURL=$urlnegativo
            &trackid=$trackid
            &udf1=".$user->email."
            &udf2=".$user->mobile."
            &udf3=".$user->firstname."
            &udf4=".$user->lastname."
            &udf5=EE";
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

    /**
     * Pagina di visualizzazione esito transazione
     *
     * @return \Illuminate\View\View
     */
    public function result(){

        if(!Auth::check()){
            //Controllo esistenza mail gia registrata
            $user = User::where('email','=',Input::get('email'))->get();

            //se non esiste utenza, la creo
            if($user->isEmpty()){

              $userObj = (object)Session::get('user');
              $user = User::create([
                'firstname' => $userObj->firstname,
                'lastname'  => $userObj->lastname,
                'mobile'    => $userObj->mobile,
                'email'     => $userObj->email,
                'address'   => $userObj->address,
                'cap'       => $userObj->cap,
                'city'      => $userObj->city
              ]);
            }else
                $user = $user->first();

        }else //se utente è loggato
            $user = Auth::user();

        //inizializzo il pagamento inserendo i dati di spedizione del form e non quelli dell'user
        $userObj = (object)Session::get('user');
        $payment = new Payment([
                'pay_date'  => time(),
                'total'     =>  0,
                'status'    => Input::get('resultcode'),
                'trackid'   => Input::get('trackid'),
                'firstname' => $userObj->firstname,
                'lastname'  => $userObj->lastname,
                'mobile'    => $userObj->mobile,
                'email'     => $userObj->email,
                'city'      => $userObj->city,
                'cap'       => $userObj->cap,
                'address'   => $userObj->address
        ]);

        $payment->user()->associate($user);
        $feedback = new Feedback(['uuid' => Str::random(32)]);
        $feedback->save();
        $payment->feedback()->associate($feedback);
        $payment->save();

        //inizializzo i ordini
        $orders = [];
        $cart = Session::get('cart');
        $total_amount = 0;

        //calcolo il totale del carrello per salvarlo nel "payment"
        foreach($cart as $ticket_id => $quantity){
            $ticket = Ticket::find($ticket_id);
            $temp = new Order(['quantity'  => $quantity]);
            $temp->ticket()->associate($ticket);
            $temp->payment()->associate($payment);
            $orders[] = $temp;
            $total_amount += $ticket->price * $quantity;

        }
        //salvo totale
        $payment->total = $total_amount;
        $payment->save();

        //associo ordini al payment
        $payment->orders()->saveMany($orders);

        //associo i consumer ai order
        $customers_session = Session::get('consumers');
        foreach($orders as $order){
            if($order->ticket->category_id == Match::$football){
                $consumers = [];//lista di consumer
                foreach($customers_session as $cust){
                    if($cust['ticket_id'] == $order->ticket_id)
                        $consumers[] = new Consumer($cust);
                }
                if(!empty($consumers))
                    $order->consumers()->saveMany($consumers);
            }
        }

        $data['payment'] = serialize($payment);
        $data['feedback']= serialize($feedback);
        $data['user']    = serialize($user);

        if(Input::get('resultcode') == "APPROVED"){
            //aggiorno ticket disponibili
            foreach($cart as $ticket_id => $quantity){
                $ticket = Ticket::find($ticket_id);
                $ticket->quantity -= $quantity;
                $ticket->save();
            }
           //svuoto carrello
           Session::forget('cart');
        }

        $errorText = Input::get('ErrorText');
        $data['errorCode'] = Input::get('Error');
        $data['errorText'] = $errorText;

        Mail::queue('emails.newpayment', $data, function($message) use ($payment,$userObj)
        {
           if(Input::get('resultcode') == "APPROVED")
                $subject = "Order has been placed ! - #".$payment->trackid;
           else
                $subject = "Problem processing payment !";

            $message->to($userObj->email)->subject('Stadium - '.$subject);
            $message->to(\Config::get('administrator.email'))->subject('Stadium - '.$subject);
        });

       return View::make($this->viewFolder.'cart.result',compact('payment','user','errorText'));
    }

    /**
     * Se il consorzio non riesce a indirizzare l'user all metodo receipt
     * allora verrà spedito qui.
     */
    public function error(){
        header("Access-Control-Allow-Origin: *");
        $error['code'] = Input::get('Error');
        $error['text'] = Input::get('ErrorText');
        echo $error['code'];
    }

    /**
     * Una volta che il pagamento è stato processato dal consorzio triveneto,
     * indipendentemente dal suo esito (fallito o successo)
     * viene richiamato, redirezionerà l'user alla pagina result.
     */
    public function receipt(){

        header("Access-Control-Allow-Origin: *");

        if(isset($_POST['Error'])){
            echo "REDIRECT=http://stadium.reexon.net/cart/result?PaymentID=".$_POST["paymentid"].
                "&Error=".$_POST['Error'].
                "&ErrorText=".$_POST['ErrorText'];
        }else{
            $PayID=$_POST["paymentid"];
            $responseCode =$_POST["responsecode"];
            $TransID=$_POST["tranid"];
            $ResCode=$_POST["result"];
            $AutCode=$_POST["auth"];
            $PosDate=$_POST["postdate"];
            $TrckID=$_POST["trackid"];
            $cardType =$_POST['cardtype'];
            $email=$_POST["udf1"];
            $mobile=$_POST["udf2"];
            $firstname=$_POST["udf3"];
            $lastname=$_POST["udf4"];

            $UD5=$_POST["udf5"];

            $ReceiptURL="REDIRECT=http://stadium.reexon.net/cart/result?PaymentID=".$PayID.
                "&TransID=".$TransID.
                "&trackid=".$TrckID.
                "&postdate=".$PosDate.
                "&resultcode=".$ResCode.
                "&cardtype=".$cardType.
                "&auth=".$AutCode.
                "&responseCode=".$responseCode.
                "&email=".$email.
                "&mobile=".$mobile.
                "&firstname=".$firstname.
                "&lastname=".$lastname;

            echo $ReceiptURL;
        }
    }
} 
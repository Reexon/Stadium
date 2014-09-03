<?php

namespace Frontend\Controller;

use View;
use Session;
use Backend\Model\Ticket;
class CartController extends BaseController{

    public function info(){
        $cart = Session::get('cart');

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

    public function checkout(){

    }

} 
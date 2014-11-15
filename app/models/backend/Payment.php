<?php
namespace Backend\Model;

use Backend\Controller\UPSCourrier;

class Payment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
         'total' => 'required',
         'pay_date' => 'required|date'
	];

    public static $rules_update = [
        'pay_date' => 'required|date'
    ];

    protected $primaryKey = 'id_payment';

	// Don't forget to fill this array
	protected $fillable = ['pay_date','total','trackid','status','trackingcode','firstname','lastname','city','cap','address','email','mobile'];

    //campi in formato data
    protected $dates = ['pay_date'];

    protected $perPage = 10;

    public $signedBy = null;

    public function shippingStatus(){

        if(empty($this->trackingcode)) return;
        $ups = new UPSCourrier($this->trackingcode);
        $ups->start();

    }

    /**
     * Una volta che l'admin visualizza il pagamento, lo segno come letto.
     */
    public function markAsVisited(){
        $this->visited = true;
        $this->save();
    }

    /**
     * Per qualsiasi motivo l'admin puo' segnare un pagamento come avvenuto
     */
    public function markAsPaid(){
        $this->status = "APPROVED";
        $this->save();
    }

    /**
     * Per qualsiasi motivo l'admin puo' segnare un pagamento come avvenuto
     */
    public function markAsUnpaid(){
        $this->status = "NOT APPROVED";
        $this->save();
    }

    /**
     * Ritorna lo stato del pagamento
     *
     * @return bool
     */
    public function getisPaidAttribute(){
        return $this->status == "APPROVED" ? true : false;
    }

    /**
     *
     * Prelevo tutti gli ordini presenti nel pagamento
     * Ogni ordine identifica una tipologia di ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return Payment::hasMany('Backend\Model\Order');
    }

    /**
     *
     * Prelevo informazioni su chi ha effettuato il pagamento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return Payment::belongsTo('Backend\Model\User');
    }

    /**
     * Prelevo informazioni sul feedback associato al pagamento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feedback(){
        return $this->belongsTo('Backend\Model\Feedback');
    }


    public function hasEventOfCategory($category_id){
        //$payment = Payment::with('orders.ticket.event')->where('id_payment','=',$this->id_payment)->get();
        foreach ($this->orders as $order){
            if($order->ticket->event->category_id == $category_id) return true;
        }
        return false;
    }

    public function getHasFootballEventAttribute(){
        return $this->hasEventOfCategory(Match::$football);
    }

    /**
     * Restituisce il Nome e Cognome della persona a cui deve essere spedito il pacco
     */
    public function getFullnameAttribute(){
        return $this->firstname." ".$this->lastname;
    }

    /**
     * Restituisce lo stato del pacco , se consegnato o no
     */
    public function getIsDeliveredAttribute(){
        return !is_null($this->signedBy);
    }

    /**
     * all payments not shipped yet
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotShipped($query){
        return $query->whereNull('trackingcode');
    }

    /**
     * all approved payments
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeApproved($query){
        return $query->where('status','=','APPROVED');
    }

    /**
     * all non- approved payment
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotApproved($query){
        return $query->where('status','=','NOT APPROVED');
    }

    /**
     * payments visited
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotVisited($query){
        return $query->where('visited','=','0');
    }

    /**
     * already visited payments
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeVisited($query){
        return $query->where('visited','=','1');
    }
}
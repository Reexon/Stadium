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

}
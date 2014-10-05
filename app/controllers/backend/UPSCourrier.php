<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 25/09/14
 * Time: 13:02
 */

namespace Backend\Controller;


use Backend\Model\Payment;

class UPSCourrier{

    //Dati Di accesso per utilizzo delle API (NON MODIFICARE)
    private $userID = "amaltea";
    private $password = "Fra62nco";
    private $accessLicenseNumber="CCDCC8C9BAF52C85";

    //Dati relativi al tipo di richiesta
    private $trackingEndPoint = "https://wwwcie.ups.com/ups.app/xml/Track";
    private $trackingCode = "1Z49E03Y6840179212"; //in shipping
    //private $trackingCode = "1Z49E03Y6840211873"; //delivered
    //private $trackingCode = "990728071";//in transit
    //private $trackingCode = "1Z12345E029198079";//invalid tracking number (error)
    //private $trackingCode = "1Z12345E1591910450";//No tracking info avvailable (error)
    /**
     * @var string
     * Activity (All) - Il WS Ritornerà tutti gli step che il package ha passato
     * None(Last)     - Il WS Ritornerà solo l'ultimo stato del pacco.
     */
    private $requestType = "6";

    //gestione di eventuali errori
    public $errorCode = null;
    public $errorDescription = null;

    //In Transit - Delivered -
    public $currentStatus = null;
    public $deliver;

    //boolean
    public $isDelivered;
    //nome di chi ha firmato (se è stato consegnato)
    public $signedBy = null;
    //data ultimo aggiornamento
    public $lastUpdateDate;
    //ora ultimo aggiornamento
    public $lastUpdateTime;
    /*
     * array key  => value
     *
     */
    public $shipTo;

    public function __construct($tracking){
        $this->trackingCode = $tracking;
        $this->start();
    }

    private function accessXML(){
        return "<?xml version=\"1.0\" ?>
                    <AccessRequest>
                      <AccessLicenseNumber>".$this->accessLicenseNumber."</AccessLicenseNumber>
                      <UserId>".$this->userID."</UserId>
                      <Password>".$this->password."</Password>
                    </AccessRequest>";
    }

    private function trackingRequestXML(){
        return "<?xml version=\"1.0\" ?>
                    <TrackRequest>
                      <Request>
                        <TransactionReference>
                          <CustomerContext></CustomerContext>
                          <TransactionIdentifier></TransactionIdentifier>
                          <ToolVersion></ToolVersion>
                        </TransactionReference>
                        <RequestAction>Track</RequestAction>
                        <RequestOption>".$this->requestType."</RequestOption>
                      </Request>
                      <TrackingNumber>".$this->trackingCode."</TrackingNumber>
                    </TrackRequest>";
    }

    public function start(){
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        $ch = curl_init($this->trackingEndPoint);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // disable SSL verification if not installed
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);                // use Secure Socket v3 SSL3
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'SSLv3');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS,$this->accessXML().$this->trackingRequestXML());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $this->analyzeXML($response);
    }

    private function analyzeXML($xml){

        $xml = simplexml_load_string($xml);
        //Controllo se non ci sono problemi strani
        if($xml->Response->ResponseStatusCode == 0){
            $this->errorCode = $xml->Response->Error->ErrorCode;
            $this->errorDescription = $xml->Response->Error->ErrorDescription;
            $this->currentStatus = $this->errorDescription;
            return;
        }

        //Indirizzo di spedizione
        $shipTo = $xml->Shipment->ShipTo->Address;
        if($shipTo != null){
            $this->shipTo['AddressLine1'] = $shipTo->AddressLine1;
            $this->shipTo['AddressLine2'] = $shipTo->AddressLine2;
            $this->shipTo['City'] = $shipTo->City;
            $this->shipTo['StateProvinceCode'] = $shipTo->StateProvinceCode;
            $this->shipTo['PostalCode'] = $shipTo->PostalCode;
            $this->shipTo['CountryCode'] = $shipTo->CountryCode;
        }

        //a quanto pare questo serve solo nel caso in cui il pacco sia in transito
        /*$currentStatus = $xml->Shipment->CurrentStatus->Description;
        if ($currentStatus != null){
            $this->currentStatus = $currentStatus;
            $this->deliver['status'] = $xml->Shipment->DeliveryDateTime->Type->Description;
            $this->deliver['date'] = date('d.m.Y',strtotime($xml->Shipment->DeliveryDateTime->Date));
            echo $this->deliver['status']." : ".$this->deliver['date'];
        }*/

        /*
         * Type of activity status: activity
         *   I = In Transit
         *   D = Delivered
         *   X = Exception
         *   P = Pickup
         *   M = Manifest Pickup.
         */

        if($xml->Shipment->Package->Activity != null){
            foreach($xml->Shipment->Package->Activity as $activityData){

                //consegnato o no
                $statusCode = $activityData->Status->StatusType->Code;

                if($statusCode == "D"){
                    $this->isDelivered = true;
                    $this->signedBy = $activityData->ActivityLocation->SignedForByName;

                }else
                    $this->isDelivered = false;

                $this->currentStatus = $activityData->Status->StatusType->Description;
                $this->lastUpdateDate = date('d.m.Y',strtotime($activityData->Date));
                $this->lastUpdateTime = date('H:i:s',strtotime($activityData->Time));
            }
        }
    }

} 
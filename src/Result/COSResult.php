<?php

namespace Chalcedonyt\COSProcessor\Result;

class COSResult
{
    /**
     * @var float
     */
    protected $amount;

    /**
     * @var String Three-letter currency code
     */
    protected $currency;

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * @var String
     */
    protected $fullname;

    /**
    * @var String The file identifier, from a previously generated COS csv file.
    */
    protected $fileIdentifier;

    /**
     * @var int The payment id, usually from a model
     */
    protected $paymentId;

    /**
     * @var int The bank transaction id
     */
    protected $transactionId;

    /**
     * @param float
     */
    public function setAmount($amount){
        $this -> amount = $amount;
    }

    /**
     * @param String
     */
    public function setCurrency($currency){
        $this -> currency = $currency;
    }

    /**
     * @param DateTime
     */
    public function setDateTime(\DateTime $dateTime ){
        $this -> dateTime = $dateTime;
    }
    /**
    * @param String
    */
    public function setFileIdentifier($identifier){
        $this -> fileIdentifier = $identifier;
    }

    /**
     * @param String
     */
    public function setFullname($fullname){
        $this -> fullname = $fullname;
    }

    /**
     * @param int
     */
    public function setPaymentId($payment_id){
        $this -> paymentId = $payment_id;
    }

    /**
     * @param String
     */
    public function setTransactionId($transaction_id){
        $this -> transactionId = $transaction_id;
    }

    public function __get($property){
        if( property_exists( $this, $property )){
            return $this -> $property;
        }
    }
}
?>

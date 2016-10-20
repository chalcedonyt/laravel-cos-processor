<?php

namespace Chalcedonyt\COSProcessor\Adapter\Result\HSBC;

use Chalcedonyt\COSProcessor\Adapter\Result\COSResultAdapterAbstract;
use Chalcedonyt\COSProcessor\Result\COSResult;
use Chalcedonyt\COSProcessor\Exceptions\COSProcessorException;

class HSBCCOSResultAdapter extends COSResultAdapterAbstract
{
    const OFFSET_PAYMENT_ID = 1;
    const OFFSET_TRANSACTION_ID = 2;
    const OFFSET_FULLNAME = 12;
    const OFFSET_AMOUNT = 7;
    const OFFSET_CURRENCY = 6;
    const OFFSET_DATETIME = 5;

    /**
     * @param String The line to parse
     */
    public function __construct($string){
        parent::__construct($string);
        
        $result = new COSResult();
        $result -> setPaymentId( trim($this -> columns[self::OFFSET_PAYMENT_ID]));
        $result -> setTransactionId( trim($this -> columns[self::OFFSET_TRANSACTION_ID]));
        $result -> setFullname(trim($this -> columns[self::OFFSET_FULLNAME]));
        $result -> setAmount(trim($this -> columns[self::OFFSET_AMOUNT]));
        $result -> setCurrency(trim($this -> columns[self::OFFSET_CURRENCY]));

        $datetime = \DateTime::createFromFormat('d/m/Y', trim($this -> columns[self::OFFSET_DATETIME]));
        $result -> setDateTime($datetime);
        $this -> cosResult = $result;
    }

}
?>

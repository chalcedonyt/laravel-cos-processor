<?php
namespace Chalcedonyt\COSProcessor\Column;

use Chalcedonyt\COSProcessor\Stringable;
use Chalcedonyt\COSProcessor\Exceptions\COSProcessorColumnException;

class DateColumn extends Column implements Stringable
{
    /**
     * @var Datetime
     */
    protected $date;

    /**
     * @var String representation of date, passed to datetime -> format
     */
    protected $format;

    /**
     * @return mixed
     */
    public function getString(){
        return parent::getPaddedValue( $this -> date -> format($this -> format));
    }

    /**
     * @param String
     */
    public function setFormat($format){
        $this -> format = $format;
    }
    /**
     * @param Datetime
     */
    public function setDate(\Datetime $date){
        $this -> date = $date;
    }
}

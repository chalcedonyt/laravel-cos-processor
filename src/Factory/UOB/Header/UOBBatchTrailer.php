<?php

namespace Chalcedonyt\COSProcessor\Factory\UOB\Header;

use Chalcedonyt\COSProcessor\Line\Line;
use Chalcedonyt\COSProcessor\Line\Header;
use Chalcedonyt\COSProcessor\Beneficiary;
use Chalcedonyt\COSProcessor\BeneficiaryLines;
use Chalcedonyt\COSProcessor\Column\Date;
use Chalcedonyt\COSProcessor\Factory\Column\ConfigurableStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\EmptyColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\LeftPaddedDecimalWithoutDelimiterColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\LeftPaddedZerofillStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\PresetStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\RightPaddedStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\VariableLengthStringColumnFactory;

/**
 * For UOB, a batch trailer comes at the end of the file.
 */
class UOBBatchTrailer extends Header
{
    protected $columnDelimiter = "";

    /**
     * @return Line
     */
    public function getLine(){
        $line = new Line();
        $columns = [
            'record_type'       => PresetStringColumnFactory::create('9', $label = 'record_type'),
            'no_trans'          => LeftPaddedZerofillStringColumnFactory::create( $this -> getBeneficiaryCount(), $length = 8, $label = 'no_trans'),
            'ttl_payment_amt'   => LeftPaddedDecimalWithoutDelimiterColumnFactory::create( $this -> getTotalPaymentAmount(), $length = 15 , $label = 'ttl_payment_amt'),
            'filler'            => RightPaddedStringColumnFactory::create('', $length = 876 , $label = 'filler')
        ];
        $line -> setColumns($columns);
        return $line;
    }

}

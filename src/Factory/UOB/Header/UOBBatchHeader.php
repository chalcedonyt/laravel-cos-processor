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
use Chalcedonyt\COSProcessor\Factory\Column\PresetStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\RightPaddedStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\VariableLengthStringColumnFactory;


class UOBBatchHeader extends Header
{
    protected $columnDelimiter = "";

    /**
     * @return Line
     */
    public function getLine(){
        $line = new Line();
        $line -> setColumnDelimiter("");
        $columns = [
            'record_type'                   => PresetStringColumnFactory::create('1', $label = 'record_type'),
            'batch_no'                      => RightPaddedStringColumnFactory::create('', 20, $label = 'batch_no'),
            'payment_advice_header_line1'   => RightPaddedStringColumnFactory::create( '', 105, $label = 'payment_advice_header_line1'),
            'payment_advice_header_line2'   => RightPaddedStringColumnFactory::create( '', 105, $label = 'payment_advice_header_line2'),
            'filler'                        => RightPaddedStringColumnFactory::create('', 669, $label = 'filler')
        ];
        $line -> setColumns($columns);
        return $line;
    }

}

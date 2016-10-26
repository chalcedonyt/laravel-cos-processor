<?php

namespace Chalcedonyt\COSProcessor\Factory\HSBC\Header;

use Chalcedonyt\COSProcessor\Line\Line;
use Chalcedonyt\COSProcessor\Beneficiary;
use Chalcedonyt\COSProcessor\BeneficiaryLines;
use Chalcedonyt\COSProcessor\Column\Date;
use Chalcedonyt\COSProcessor\Factory\Column\ConfigurableStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\EmptyColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\LeftPaddedDecimalWithoutDelimiterColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\PresetStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\RightPaddedStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\VariableLengthStringColumnFactory;

use Chalcedonyt\COSProcessor\Factory\BeneficiaryFactoryInterface;

class HSBCFileHeader extends \Chalcedonyt\COSProcessor\Line\Header implements BeneficiaryFactoryInterface
{
    const FILE_REFERENCE_PREFIX = 'IFILEPYT_';

    /**
     * How many lines make up a beneficiary entry
     * @var int
     */
    protected $beneficiaryLineHeight = 3;
    
    /**
     * @return Line
     */
    public function getLine(){
        $line = new Line();
        $columns = [
            'record_type'               => PresetStringColumnFactory::create('IFH', $label = 'record_type'),
            'file_format'               => ConfigurableStringColumnFactory::create($config = $this -> config, 'file_format', $label = 'file_format'),
            'file_type'                 => ConfigurableStringColumnFactory::create($config = $this -> config, 'file_type', $label = 'file_type'),
            'hexagon_abc_customer_id'   => ConfigurableStringColumnFactory::create($config = $this -> config, 'hexagon_abc_customer_id', $label = 'hexagon_abc_customer_id'),
            'hsbcnet_id'                => ConfigurableStringColumnFactory::create($config = $this -> config, 'hsbcnet_id', $label = 'hsbcnet_id'),
            'file_reference'            => VariableLengthStringColumnFactory::create($this -> getFileReference(), 35, $label = 'file_reference'),
            'file_creation_date'        => VariableLengthStringColumnFactory::create(date('Y/m/d'), 10, $label = 'file_creation_date'),
            'file_creation_time'        => VariableLengthStringColumnFactory::create(date('H:i:s'), 8, $label = 'file_creation_time'),
            'authorization_type'        => PresetStringColumnFactory::create('P', $label = 'authorization_type'),
            'file_version'              => ConfigurableStringColumnFactory::create($config = $this -> config, 'file_version', $label = 'file_version'),
            'record_count'              => VariableLengthStringColumnFactory::create($this -> getTotalLines(), 7 , $label = 'record_count'),
        ];
        $line -> setColumns($columns);
        return $line;
    }

    /**
     * @return String
     */
    public function getFileReference(){
        //fix to the current minute
        $time = strtotime(date('Y-m-d H:i:00'));
        return self::FILE_REFERENCE_PREFIX.$time;
    }

    /**
    * @return String
    */
    public function getFileName(){
        return 'hsbc_cos_'.time();
    }

    /**
    * @return String
    */
    public function getFileExtension(){
        return 'csv';
    }

}

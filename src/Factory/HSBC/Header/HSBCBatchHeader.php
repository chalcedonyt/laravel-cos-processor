<?php

namespace Chalcedonyt\COSProcessor\Factory\HSBC\Header;

use Chalcedonyt\COSProcessor\Line\Line;
use Chalcedonyt\COSProcessor\Stringable;
use Chalcedonyt\COSProcessor\Beneficiary;
use Chalcedonyt\COSProcessor\BeneficiaryLines;
use Chalcedonyt\COSProcessor\Column\Date;
use Chalcedonyt\COSProcessor\Factory\Column\ConfigurableStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\EmptyColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\LeftPaddedDecimalWithoutDelimiterColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\PresetStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\RightPaddedStringColumnFactory;
use Chalcedonyt\COSProcessor\Factory\Column\VariableLengthStringColumnFactory;


class HSBCBatchHeader extends \Chalcedonyt\COSProcessor\Line\Header implements Stringable
{
    const FILE_REFERENCE_PREFIX = 'IFILEPYT_';

    /**
     * @param Beneficiary
     * @return BeneficiaryLines
     */
    public function getLine(){
        $line = new Line();
        $columns = [
            'record_type'                       => PresetStringColumnFactory::create('BATHDR', $label = 'record_type'),
            'instruction_type'                  => PresetStringColumnFactory::create('COS', $label = 'instruction_type'),
            'total_instructions'                => VariableLengthStringColumnFactory::create( $this -> getBeneficiaryCount(), $max_length = 7, $label = 'total_instructions'),
            'batch_reference'                   => EmptyColumnFactory::create( $label = 'batch_reference'),
            'filter_1'                          => EmptyColumnFactory::create( $label = 'filter_1'),
            'filter_2'                          => EmptyColumnFactory::create( $label = 'filter_2'),
            'filter_3'                          => EmptyColumnFactory::create( $label = 'filter_3'),
            'filter_4'                          => EmptyColumnFactory::create( $label = 'filter_4'),
            'filter_5'                          => EmptyColumnFactory::create( $label = 'filter_5'),
            'constant_eye_catcher'              => PresetStringColumnFactory::create('@1ST@', $label = 'constant_eye_catcher'),
            'value_date'                        => EmptyColumnFactory::create( $label = 'value_date'),
            'first_party_account'               => ConfigurableStringColumnFactory::create($this -> config, 'first_party_account', $label = 'first_party_account'),
            'transaction_currency'              => EmptyColumnFactory::create( $label = 'transaction_currency'),
            'transaction_amount'                => EmptyColumnFactory::create( $label = 'transaction_amount'),
            'template_mode'                     => EmptyColumnFactory::create( $label = 'template_mode'),
            'batch_template_id'                 => EmptyColumnFactory::create( $label = 'batch_template_id'),
            'first_party_acc_country_code'      => ConfigurableStringColumnFactory::create($this -> config, 'first_party_account_country_code', $label = 'first_party_acc_country_code'),
            'first_party_acc_institution_code'  => ConfigurableStringColumnFactory::create($this -> config, 'first_party_account_institution_code', $label = 'first_party_acc_institution_code'),
            'first_party_acc_currency'          => ConfigurableStringColumnFactory::create($this -> config, 'first_party_account_currency', $label = 'first_party_acc_currency'),
            'payment_amount_debit_acc_currency' => EmptyColumnFactory::create( $label = 'payment_amount_debit_acc_currency'),
            'first_party_name'                  => EmptyColumnFactory::create( $label = 'first_party_name'),
            'first_party_info_1'                => EmptyColumnFactory::create( $label = 'first_party_info_1'),
            'first_party_info_2'                => EmptyColumnFactory::create( $label = 'first_party_info_2'),
            'first_party_info_3'                => EmptyColumnFactory::create( $label = 'first_party_info_3'),
            'first_party_info_4'                => EmptyColumnFactory::create( $label = 'first_party_info_4'),
            'payment_code'                      => EmptyColumnFactory::create( $label = 'payment_code'),
            'reference_line_1'                  => VariableLengthStringColumnFactory::create($this -> getFileReference(), $max_length = 35, $label = 'reference_line_1')
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

}

<?php
namespace Chalcedonyt\COSProcessor\Adapter;

use Chalcedonyt\COSProcessor\Stringable;
use Chalcedonyt\COSProcessor\Exceptions\COSProcessorColumnException;

class ExampleBeneficiaryAdapter extends BeneficiaryAdapterAbstract implements BeneficiaryAdapterInterface
{
    /**
     * @param Model
     */
    public function __construct($model){
        $this -> model = $model;

        $this -> email = $model -> email;
        $this -> fullname = strtoupper($model -> fullname);

        //Map the user's full name to name1, name2, name3
        $name_parts = static::getStringParts($model -> fullname);
        for( $i = 1; $i <= count($name_parts); $i++ ){
            $var = "name".$i;
            $this -> $var = $name_parts[$i];
        }

        //Map the user's address to address1, address2, address3
        $address_parts = static::getStringParts($model -> address);
        for( $i = 1; $i <= count($address_parts); $i++ ){
            $var = "address".$i;
            $this -> $var = $address_parts[$i];
        }

        $this -> paymentAmount = $model -> payment_amount;
        $this -> paymentDateTime = $model -> payment_date;
        $this -> paymentId = $model -> payment_id;
        $this -> postcode = $model -> postcode;
        $this -> title = $model -> title;
        $this -> userId = $model -> user_id;
    }

    /**
     * @param String
     * @param Array
     */
    public static function getStringParts($string, $max_parts = 3){
        $max_length = 35;

        $string = strtoupper(str_replace(["\n", "\r\n", "\r"], $string));
        $wordwrapped = wordwrap($string, $name_length, '{}@', true);
        $string_parts = explode('{}@', $wordwrapped);

        if( count( $string_parts ) > $max_parts){
            throw new COSProcessorColumnException(sprintf("The string %s was too long", $string));
        }
        return $string_parts;
    }

    /**
     * @return String
     * For HSBC.
     * "M" - Mr
     * "R" - Mrs
     * "S" - Ms
     * "O" - Other
     */
    public function getRecipientTitleFlag(){
        switch( strtoupper($this -> model -> title)){
            case "mr":
                return "M";
            case "mrs":
                return "R";
            case "ms":
                return "S";
            default:
                return "O";
        }
    }

    /**
     * @return String
     * A description for title flag, if the value was O.
     */
    public function getRecipientTitleDescription(){
        switch( strtoupper($this -> model -> title)){
            case "dr":
                return "Dr";
            default:
                return "";
        }
    }

}

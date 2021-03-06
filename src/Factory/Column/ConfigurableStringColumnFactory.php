<?php

namespace Chalcedonyt\COSProcessor\Factory\Column;

use Chalcedonyt\COSProcessor\Exceptions\COSProcessorColumnException;
use Chalcedonyt\COSProcessor\Column\Column;
use Chalcedonyt\COSProcessor\Line\Line;
use Config;

class ConfigurableStringColumnFactory
{
    /**
     * Creates a column with a value from config file.
     * Length will be set to the length of the configured value.
     * @param Line the parent line
     * @param String. Config key. The resolved value will be cast to a string.
     * @param String An optional label for the column, used in error messages.
     * @return Column
     */
    public static function create($config, $config_key, $label = ''){
        if( !$config -> has($config_key)){
            throw new COSProcessorColumnException('Could not find the config option '.$config_key);
        }
        $value = (string)$config -> get($config_key);;
        $column = new Column();
        $column -> setLabel($label);
        $column -> setValue($value);
        return $column;
    }
}

<?php

namespace Chalcedonyt\COSProcessor\Factory\HSBC;

use Chalcedonyt\COSProcessor\Factory\HSBC\Header\HSBCFileHeader;
use Chalcedonyt\COSProcessor\Factory\HSBC\Header\HSBCBatchHeader;

use Chalcedonyt\COSProcessor\Factory\HSBC\HSBCBeneficiaryFactory;
use Chalcedonyt\COSProcessor\Adapter\BeneficiaryAdapterInterface;
use Chalcedonyt\COSProcessor\COSUploadProcessor;

use Illuminate\Config\Repository;

class HSBCCOSUploadProcessorFactory
{
    /**
     * @param Collection of entries to be passed into the adapter
     * @return String
     */
    public static function createCsvString($beneficiaries, $config_key)
    {
        $config = new Repository(config($config_key));
        $adapter_class = $config['beneficiary_adapter'];

        $beneficiaries = $beneficiaries -> map( function($payment) use($adapter_class){
            return new $adapter_class($payment);
        }) -> toArray();

        $beneficiary_lines = collect($beneficiaries) -> map( function(BeneficiaryAdapterInterface $beneficiary) use ($config_key){
            return HSBCBeneficiaryFactory::create($beneficiary, $config_key);
        }) -> toArray();

        $cos = new COSUploadProcessor($beneficiaries);

        $file_header = new HSBCFileHeader($beneficiaries, $config_key);
        $batch_header = new HSBCBatchHeader($beneficiaries, $config_key);

        $cos -> setFileHeader($file_header);
        $cos -> setBatchHeader($batch_header);
        $cos -> setBeneficiaryLines($beneficiary_lines);

        return $cos -> getString();
    }
}

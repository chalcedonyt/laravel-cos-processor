<?php

namespace Chalcedonyt\COSProcessor\Factory\UOB;

use Chalcedonyt\COSProcessor\Factory\UOB\Header\UOBFileHeader;
use Chalcedonyt\COSProcessor\Factory\UOB\Header\UOBBatchHeader;
use Chalcedonyt\COSProcessor\Factory\UOB\Header\UOBBatchTrailer;
use Chalcedonyt\COSProcessor\Factory\UOB\UOBBeneficiaryFactory;

use Chalcedonyt\COSProcessor\Adapter\BeneficiaryAdapterInterface;
use Chalcedonyt\COSProcessor\COSUploadProcessor;

use Illuminate\Config\Repository;

class UOBCOSUploadProcessorFactory
{
    /**
     * @param Collection of entries to be passed into the adapter
     * @param String The config key to read from
     * @param Int The sequence number for file name generation. If multiple files are generated in a day, this number should be incremented.
     * @return String
     */
    public static function createCsvString($beneficiaries, $config_key, $sequence_number = 1)
    {
        $config = new Repository(config($config_key));
        $adapter_class = $config['beneficiary_adapter'];

        $beneficiaries = $beneficiaries -> map( function($payment) use($adapter_class){
            return new $adapter_class($payment);
        }) -> toArray();

        $beneficiary_lines = collect($beneficiaries) -> map( function(BeneficiaryAdapterInterface $beneficiary) use($config_key){
            return UOBBeneficiaryFactory::create($beneficiary, $config_key);
        }) -> toArray();

        $cos = new COSUploadProcessor($beneficiaries, $config_key);

        $file_header = new UOBFileHeader($beneficiaries, $config_key);
        $file_header -> setSequenceNumber($sequence_number);
        //UOB uses fixed length strings, so no column delimiters are needed
        $file_header -> setColumnDelimiter("");

        $batch_header = new UOBBatchHeader($beneficiaries, $config_key);
        $batch_header -> setColumnDelimiter("");

        $batch_trailer = new UOBBatchTrailer($beneficiaries, $config_key);
        $batch_trailer -> setColumnDelimiter("");

        $cos -> setFileHeader($file_header);
        $cos -> setBatchHeader($batch_header);
        $cos -> setBatchTrailer($batch_trailer);
        $cos -> setBeneficiaryLines($beneficiary_lines);

        return $cos -> getString();
    }
}

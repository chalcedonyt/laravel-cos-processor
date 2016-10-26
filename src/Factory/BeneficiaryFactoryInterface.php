<?php
namespace Chalcedonyt\COSProcessor\Factory;

interface BeneficiaryFactoryInterface
{
    /**
    * @return String
    */
    public function getFileName();

    /**
    * @return String
    */
    public function getFileExtension();
}
?>
# COS Processor for Laravel

Helper functions to deal with COS (Cheque Outsourcing Services). Generates files based on payment entries. UOB and HSBC supported at the moment. Look at the files under the documentation/ folder for the original documents from UOB and HSBC.

## Install

Via Composer

``` bash
$ composer require chalcedonyt/laravel-cos-processor
```

## Creating an Adapter

Create an adapter that implements `Chalcedonyt\\COSProcessor\\Adapter\\BeneficiaryAdapterInterface`. This should translate your model into the attributes that will be used in the COS entries. Refer to `Chalcedonyt\\COSProcessor\\Adapter\\ExampleBeneficiaryAdapter` for an example.

## Configuration

`php artisan vendor:publish` should publish a `cos_processor.php` into the config folder. Edit this with the configuration options for your account. Change `"beneficiary_adapter"` to the class of the adapter you created earlier.


## Usage

Call the relevant COSUploadProcessorFactory subclass and pass in your data, and the config key.


``` php
$beneficiaries = TestPayment::all();
$cos = HSBCCOSUploadProcessorFactory::createCsvString($beneficiaries, 'hsbc_example');
echo $cos;
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

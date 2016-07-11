<?php

use Illuminate\FileSystem\Filesystem;
use Illuminate\FileSystem\ClassFinder;
use Models\TestPayment;
use Adapter\MyBeneficiaryAdapter;
use Chalcedonyt\COSProcessor\Factory\HSBC\HSBCCOSUploadProcessorFactory;
use Chalcedonyt\COSProcessor\Factory\UOB\UOBCOSUploadProcessorFactory;

class TestFileGenerator extends Orchestra\Testbench\TestCase{

    public function setUp(){
        parent::setUp();
        $this->app['config']->set('database.default','sqlite');
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');
        //read from the tests/config file.
        $config = require 'config/cos_processor_test.php';
        $this -> app['config'] -> set('hsbc_example', $config['hsbc_example']);
        $this -> app['config'] -> set('uob_example', $config['uob_example']);

        $this -> migrate();
    }

    /**
     * run package database migrations
     *
     * @return void
     */
    public function migrate()
    {
        $fileSystem = new Filesystem;
        $classFinder = new ClassFinder;

        foreach($fileSystem->files(__DIR__ . "/migrations") as $file)
        {
            $fileSystem->requireOnce($file);
            $migrationClass = $classFinder->findClass($file);

            (new $migrationClass)->up();
        }
        foreach($fileSystem->files(__DIR__ . "/seeds") as $file)
        {
            $fileSystem->requireOnce($file);
            $migrationClass = $classFinder->findClass($file);

            (new $migrationClass)->run();
        }
    }

    public function testHSBCDownload(){
        //create an array of BeneficiaryAdapterInterface
        $beneficiaries = TestPayment::all();
        $cos = HSBCCOSUploadProcessorFactory::createCsvString($beneficiaries, 'hsbc_example');
        echo $cos;
    }

    public function testUOBDownload(){
        //create an array of BeneficiaryAdapterInterface
        $beneficiaries = TestPayment::all();

        $cos = UOBCOSUploadProcessorFactory::createCsvString($beneficiaries, 'uob_example');
        echo $cos;

    }

}

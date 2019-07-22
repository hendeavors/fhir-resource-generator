<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\XsdFileExtractor;

class FhirClassCreationSuccessTest extends TestCase
{
    protected function setUp()
    {
    }

    /**
     * @test
     */
    public function createFromZip()
    {
        $extractor = XsdFileExtractor::create();
        $extractor
        ->destinationDirectory(__DIR__ . '\..\src\bin')
        ->sourceDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'bin\testfiles');

        $generator = FhirClassGenerator::fromZip($extractor, 'fhir-all-xsd.zip');
        $response = $generator->generate();

        $this->assertTrue($response->succeeds());
    }

    /**
     * @test
     */
    public function createFromDownload()
    {
        $extractor = XsdFileExtractor::create();
        $extractor
        ->destinationDirectory(__DIR__ . '\..\src\bin')
        ->sourceDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'bin\downloadtestfiles');

        $generator = FhirClassGenerator::fromZip($extractor, 'fhir-all-xsd.zip');
        $response = $generator->generate();

        $this->assertTrue($response->succeeds());
    }

    protected function tearDown()
    {
    }
}

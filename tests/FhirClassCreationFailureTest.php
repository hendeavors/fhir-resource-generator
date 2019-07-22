<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\XsdFileExtractor;

class FhirClassCreationFailureTest extends TestCase
{
    protected function setUp()
    {
    }

    /**
     * @test
     * @expectedException \Endeavors\Fhir\InvalidSourceFileException
     */
    public function createFromZip()
    {
        $extractor = XsdFileExtractor::create();

        FhirClassGenerator::fromZip($extractor, 'sourcefile.zip');
    }

    /**
     * @test
     * @expectedException \Endeavors\Fhir\InvalidDestinationDirectoryException
     */
    public function createFromRealZip()
    {
        // not setting a directory will produce empty destination directory exception
        $extractor = XsdFileExtractor::create();
        $extractor
        ->sourceDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'bin/testfiles');

        FhirClassGenerator::fromZip($extractor, 'fhir-all-xsd.zip');
    }

    /**
     * @test
     * @expectedException \Endeavors\Fhir\InvalidDestinationDirectoryException
     */
    public function createFromPath()
    {
        FhirClassGenerator::create('somebogusdestinationdirectory');
    }

    protected function tearDown()
    {
    }
}

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
     * @expectedException \Endeavors\Fhir\InvalidSourceFileException
     */
    public function createFromPath()
    {
        FhirClassGenerator::create('sourcefile');
    }

    protected function tearDown()
    {
    }
}

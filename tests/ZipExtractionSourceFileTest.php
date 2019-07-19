<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Support\XsdFileExtractor;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\Directory;

class ZipExtractionSourceFileTest extends TestCase
{
    private $sourceFileToRead;

    protected function setUp()
    {
    }

    /**
     * @test
     * @expectedException \Endeavors\Fhir\InvalidSourceFileException
     */
    public function sourceFileCannotBeExtractedFrom()
    {
        $extractor = XsdFileExtractor::create();
        // assumes foobarbaz doesn't exist
        $path = $extractor
        ->extract('foobarbaz');
    }

    protected function tearDown()
    {
    }
}

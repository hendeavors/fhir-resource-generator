<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Support\CompressedFile;
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
        $extractor = CompressedFile::create();
        // assumes foobarbaz doesn't exist
        $path = $extractor
        ->extract('foobarbaz');
    }

    protected function tearDown()
    {
    }
}

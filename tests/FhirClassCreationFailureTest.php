<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\CompressedFile;

class FhirClassCreationFailureTest extends TestCase
{
    /**
     * @test
     * @expectedException \Endeavors\Fhir\InvalidSourceFileException
     */
    public function createFromZip()
    {
        $extractor = CompressedFile::create();

        FhirClassGenerator::fromZip($extractor, 'somebogussourcefile');
    }

    /**
     * @test
     * @expectedException \Endeavors\Fhir\InvalidDestinationDirectoryException
     */
    public function createFromPath()
    {
        FhirClassGenerator::create('somebogusdestinationdirectory');
    }
}

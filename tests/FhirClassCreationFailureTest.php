<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\CompressedFile;
use Endeavors\Fhir\Support\Directory;

class FhirClassCreationFailureTest extends TestCase
{
    protected function setUp()
    {
        Directory::create('somebogusdestinationdirectory')->remove();
    }

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
     * @expectedException \Endeavors\Fhir\InvalidSourceDirectoryException
     */
    public function createFromPath()
    {
        FhirClassGenerator::create('somebogusdestinationdirectory');
    }

    /**
     * @test
     */
    public function attemptsGenerationFromEmptyPath()
    {
        $directory = Directory::create('random');
        $directory->make();
        $result = FhirClassGenerator::create($directory->get())->generate();

        $this->assertContains('Runtime Exception', (string)$result);
    }
}

<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\CompressedFile;
use Endeavors\Fhir\Support\Directory;

class FhirClassCreationFailureTest extends TestCase
{
    protected function setUp(): void
    {
        Directory::create('somebogusdestinationdirectory')->remove();
    }

    /**
     * @test
     */
    public function createFromZip()
    {
        $extractor = CompressedFile::create();
        $this->expectException(\Endeavors\Fhir\InvalidSourceFileException::class);
        FhirClassGenerator::fromZip($extractor, 'somebogussourcefile');
    }

    /**
     * @test
     */
    public function createFromPath()
    {
        $this->expectException(\Endeavors\Fhir\InvalidSourceDirectoryException::class);
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

        $this->assertStringContainsString('Runtime Exception', (string)$result);
    }
}

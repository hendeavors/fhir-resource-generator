<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Support\CompressedFile;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\Directory;

class ZipExtractionDestinationDirectoryTest extends TestCase
{
    private $destinationDirectoryToCreate;

    private $destinationDirectoryToNotRecreate;

    protected function setUp(): void
    {
        $this->destinationDirectoryToCreate = uniqid("dd_", true);
        $this->destinationDirectoryToNotRecreate = 'destinationshouldnotberecreated';
    }

    /** @test **/
    public function destinationCannotBeCreated()
    {
        $extractor = CompressedFile::create();

        $path = $extractor
        ->getDestinationDirectory()
        ->make();

        $this->assertFalse($path);
    }

    /** @test **/
    public function shouldCreateNewDestinationDirectory()
    {
        $extractor = CompressedFile::create();

        $path = $extractor
        ->destinationDirectory($this->destinationDirectoryToCreate)
        ->getDestinationDirectory();

        $this->assertTrue($path->exists());
    }

    /** @test **/
    public function shouldNotRecreateExistingDestinationDirectory()
    {
        $extractor = CompressedFile::create();

        $path = $extractor
        ->destinationDirectory($this->destinationDirectoryToNotRecreate)
        ->getDestinationDirectory();

        $this->assertFalse($path->make());
    }

    protected function tearDown(): void
    {
        Directory::create($this->destinationDirectoryToCreate)->remove();
        Directory::create($this->destinationDirectoryToNotRecreate)->remove();
    }
}

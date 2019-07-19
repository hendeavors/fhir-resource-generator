<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Support\XsdFileExtractor;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\Directory;

class ZipExtractionDestinationDirectoryTest extends TestCase
{
    private $destinationDirectoryToCreate;

    private $destinationDirectoryToNotRecreate;

    protected function setUp()
    {
        $this->destinationDirectoryToCreate = uniqid("dd_", true);
        $this->destinationDirectoryToNotRecreate = 'destinationshouldnotberecreated';
    }

    /** @test **/
    public function destinationCannotBeCreated()
    {
        $extractor = XsdFileExtractor::create();

        $path = $extractor
        ->getDestinationDirectory()
        ->make();

        $this->assertFalse($path);
    }

    /** @test **/
    public function shouldCreateNewDestinationDirectory()
    {
        $extractor = XsdFileExtractor::create();

        $path = $extractor
        ->destinationDirectory($this->destinationDirectoryToCreate)
        ->getDestinationDirectory();

        $this->assertTrue($path->exists());
    }

    /** @test **/
    public function shouldNotRecreateExistingDestinationDirectory()
    {
        $extractor = XsdFileExtractor::create();

        $path = $extractor
        ->destinationDirectory($this->destinationDirectoryToNotRecreate)
        ->getDestinationDirectory();

        $this->assertFalse($path->make());
    }

    protected function tearDown()
    {
        Directory::create($this->destinationDirectoryToCreate)->remove();
        Directory::create($this->destinationDirectoryToNotRecreate)->remove();
    }
}

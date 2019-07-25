<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Support\CompressedFile;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\Directory;

class ZipExtractionSourceDirectoryTest extends TestCase
{
    private $sourceDirectoryToCreate;

    private $sourceDirectoryToNotRecreate;

    protected function setUp()
    {
        $this->sourceDirectoryToCreate = uniqid("sd_", true);
        $this->sourceDirectoryToNotRecreate = 'shouldnotberecreated';
    }

    /** @test **/
    public function sourceCannotBeCreated()
    {
        $extractor = CompressedFile::create();

        $path = $extractor
        ->getSourceDirectory()
        ->make();

        $this->assertFalse($path);
    }

    /** @test **/
    public function shouldCreateNewSourceDirectory()
    {
        $extractor = CompressedFile::create();

        $path = $extractor
        ->sourceDirectory($this->sourceDirectoryToCreate)
        ->getSourceDirectory();

        $this->assertTrue($path->exists());
    }

    /** @test **/
    public function shouldNotRecreateExistingSourceDirectory()
    {
        $extractor = CompressedFile::create();

        $path = $extractor
        ->sourceDirectory($this->sourceDirectoryToNotRecreate)
        ->getSourceDirectory();

        $this->assertFalse($path->make());
    }

    protected function tearDown()
    {
        Directory::create($this->sourceDirectoryToCreate)->remove();
        Directory::create($this->sourceDirectoryToNotRecreate)->remove();
    }
}

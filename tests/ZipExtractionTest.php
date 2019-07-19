<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Support\XsdFileExtractor;
use Endeavors\Fhir\FhirClassGenerator;

class ZipExtractionTest extends TestCase
{
    /** @test **/
    public function canGenerateResourcesWithValidZip()
    {
        $extractor = XsdFileExtractor::create();

        $path = $extractor
        ->sourceDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'testfiles')
        ->destinationDirectory(__DIR__ . DIRECTORY_SEPARATOR )
        ->extract('extractedfiles', 'fhir-all-xsd.zip');

        // $path = $extractor
        // ->folder('testfiles')
        // ->destination(__DIR__ . DIRECTORY_SEPARATOR . 'extractedfiles')
        // ->source(__DIR__ . DIRECTORY_SEPARATOR . 'fhir-all-xsd.zip');
        $generator = new FhirClassGenerator($path);

        $this->assertTrue($generator->generate()->succeeds());

        $this->assertFalse($generator->generate()->fails());
    }

    /** @test **/
    public function canExtractAllGenerateResourcesWithValidZip()
    {
        $extractor = XsdFileExtractor::create();

        $path = $extractor
        ->sourceDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'testfiles')
        ->destinationDirectory(__DIR__ . DIRECTORY_SEPARATOR )
        ->extractAll('extractedfiles', 'fhir-all-xsd.zip');

        // $path = $extractor
        // ->folder('testfiles')
        // ->destination(__DIR__ . DIRECTORY_SEPARATOR . 'extractedfiles')
        // ->source(__DIR__ . DIRECTORY_SEPARATOR . 'fhir-all-xsd.zip');
        $generator = new FhirClassGenerator($path);

        $this->assertTrue($generator->generate()->succeeds());

        $this->assertFalse($generator->generate()->fails());
    }

    /** @test **/
    public function cannotGenerateResourcesWithValidZip()
    {
        $extractor = XsdFileExtractor::create();

        $source = __DIR__ . DIRECTORY_SEPARATOR . 'invalidsourcetestfile.zip';

        $path = $extractor->extract(__DIR__ . DIRECTORY_SEPARATOR . 'extractedfilesfailure', $source);

        $generator = new FhirClassGenerator($path);

        $this->assertFalse($generator->generate()->succeeds());

        $this->assertTrue($generator->generate()->fails());
    }
}

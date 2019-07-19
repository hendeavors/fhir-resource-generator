<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Support\XsdFileExtractor;
use Endeavors\Fhir\FhirClassGenerator;
// C:\Users\adamr\Downloads\fhir-all-xsd (1).zip
class ZipExtractionTest extends TestCase
{
    /** @test **/
    public function canExtractZip()
    {
        $extractor = XsdFileExtractor::create();

        $xsdPath = $extractor->extract(__DIR__ . DIRECTORY_SEPARATOR . 'extractedfiles', __DIR__ . DIRECTORY_SEPARATOR . 'mytesty.zip');

        $generator = new FhirClassGenerator($xsdPath);

        $this->assertFalse($generator->generate()->succeeds());

        $this->assertTrue($generator->generate()->fails());

    }

    /** @test **/
    public function cannotExtractZip()
    {
        $extractor = XsdFileExtractor::create();

        $result = $extractor->extract(__DIR__ . DIRECTORY_SEPARATOR . 'extractedfiles', __DIR__ . DIRECTORY_SEPARATOR . 'testfile.zip');

        dd($result);
    }
}

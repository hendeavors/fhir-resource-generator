<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Support\XsdFileExtractor;

class ZipExtractionTest extends TestCase
{
    /** @test **/
    public function canExtractZip()
    {
        $extractor = XsdFileExtractor::create();

        $extractor->extract(__DIR__ . DIRECTORY_SEPARATOR . 'extractedfiles', __DIR__ . DIRECTORY_SEPARATOR . 'mytesty.zip');
    }


    public function cannotExtractZip()
    {
        $extractor = XsdFileExtractor::create();

        $extractor->extract(__DIR__ . DIRECTORY_SEPARATOR . 'extractedfiles', __DIR__ . DIRECTORY_SEPARATOR . 'testfile.zip');
    }
}

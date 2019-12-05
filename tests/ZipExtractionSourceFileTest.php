<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Support\CompressedFile;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\InvalidSourceFileException;

class ZipExtractionSourceFileTest extends TestCase
{
    /**
     * @test
     */
    public function sourceFileCannotBeExtractedFrom()
    {
        $this->expectException(InvalidSourceFileException::class);

        $extractor = CompressedFile::create();
        // assumes foobarbaz doesn't exist
        $extractor->extract('foobarbaz');
    }
}

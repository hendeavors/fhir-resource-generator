<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Resources\DSTU2\Conformance;

class FhirConformanceParserTest extends TestCase
{
    protected function setUp()
    {
    }

    /**
     * @test
     */
    public function parseFromJsonFile()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'conformance-base.json');

        $conformance = new Conformance($json);

        dd($conformance->rest, $conformance->acceptUnknown, $conformance->fhirVersion, $conformance->url, $conformance->version, $conformance->status, $conformance->name, $conformance->experimental, $conformance->publisher, $conformance->software);
    }

    protected function tearDown()
    {
    }
}

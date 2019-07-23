<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\XsdFileExtractor;
// http://launch.smarthealthit.org/ehr.html?app=http%3A%2F%2Flocalhost%3A8000%2Fsmart%2Fehr%2Flaunch%3Flaunch%3DeyJhIjoiMSIsImIiOiJiZDdjYjU0MS03MzJiLTRlMzktYWI0OS1hZTUwN2FhNDkzMjYiLCJmIjoiMSJ9%26iss%3Dhttps%253A%252F%252Flaunch.smarthealthit.org%252Fv%252Fr2%252Ffhir&user=
class FhirClassCreationSuccessTest extends TestCase
{
    protected function setUp()
    {
    }

    /**
     * @test
     */
    public function createFromZip()
    {
        $extractor = XsdFileExtractor::create();
        $extractor
        ->destinationDirectory(__DIR__ . '\..\src\bin')
        ->sourceDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'bin\testfiles');

        $generator = FhirClassGenerator::fromZip($extractor, 'fhir-all-xsd.zip');
        $response = $generator->generate();

        $this->assertTrue($response->succeeds());

        $parser = new \Endeavors\Fhir\PHPFHIRResponseParser(false);

        $content = \Endeavors\Fhir\Support\File::create(__DIR__ . DIRECTORY_SEPARATOR . 'text' . DIRECTORY_SEPARATOR . 'conformance.json');

        //dd($content->read());
        //
        //dd($content->read());

        $conformance = $parser->parse($content->read());

        dd($conformance->getIdentifier());
    }

    /**
     */
    public function createFromDownload()
    {
        $extractor = XsdFileExtractor::create();
        $extractor
        ->destinationDirectory(__DIR__ . '\..\src\bin')
        ->sourceDirectory(__DIR__ . DIRECTORY_SEPARATOR . 'bin\downloadtestfiles');

        $generator = FhirClassGenerator::fromZip($extractor, 'fhir-all-xsd.zip');
        $response = $generator->generate();

        $this->assertTrue($response->succeeds());
    }

    protected function tearDown()
    {
    }
}

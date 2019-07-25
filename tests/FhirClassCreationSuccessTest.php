<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\CompressedFile;
// http://launch.smarthealthit.org/ehr.html?app=http%3A%2F%2Flocalhost%3A8000%2Fsmart%2Fehr%2Flaunch%3Flaunch%3DeyJhIjoiMSIsImIiOiJiZDdjYjU0MS03MzJiLTRlMzktYWI0OS1hZTUwN2FhNDkzMjYiLCJmIjoiMSJ9%26iss%3Dhttps%253A%252F%252Flaunch.smarthealthit.org%252Fv%252Fr2%252Ffhir&user=
class FhirClassCreationSuccessTest extends TestCase
{
    protected function setUp()
    {
    }


    /**
     * @test
     */
    public function createFromDownload()
    {
        $definition = \Endeavors\Fhir\FhirDefinition::download();
    }

    protected function tearDown()
    {
    }
}

<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FhirDefinition;

class AutoloadedTest extends TestCase
{
    /**
     * @test
     */
    public function fhirResponseParserIsAutoloaded()
    {
        FhirDefinition::downloadFromConsole();

        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\DSTU1\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\DSTU2\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\STU3\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\R4\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\BUILD\PHPFHIRResponseParser'));
    }
}

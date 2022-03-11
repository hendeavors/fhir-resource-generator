<?php

namespace Endeavors\Fhir\Test;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FhirDefinition;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Console\ResourceRemovalCommand;

class DownloadTest extends TestCase
{
    /**
     * @test
     */
    public function silentDownload()
    {
        FhirDefinition::silentDownload();

        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\DSTU1\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\DSTU2\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\STU3\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\R4\PHPFHIRResponseParser'));
    }

    /**
     * @test
     */
    public function buildDownload()
    {
        FhirDefinition::downloadBuild();

        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\DSTU1\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\DSTU2\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\STU3\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\R4\PHPFHIRResponseParser'));
        $this->assertFalse(class_exists('Endeavors\HL7\Fhir\BUILD\PHPFHIRResponseParser'));
    }

    /**
     * @test
     */
    public function originalDownload()
    {
        FhirDefinition::download();

        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\DSTU1\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\DSTU2\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\STU3\PHPFHIRResponseParser'));
        $this->assertTrue(class_exists('Endeavors\HL7\Fhir\R4\PHPFHIRResponseParser'));
    }

    protected function tearDown(): void
    {
        Directory::create(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'input')->remove();
        (new ResourceRemovalCommand)->handle();
    }
}

<?php

namespace Endeavors\Fhir;

use Endeavors\Fhir\Server;

class FhirDefinition
{
    $validResourceLocations = [
        'http://hl7.org/fhir/DSTU1/fhir-all-xsd.zip',
        'http://hl7.org/fhir/DSTU2/fhir-all-xsd.zip',
        'http://hl7.org/fhir/STU3/fhir-all-xsd.zip',
        'http://build.fhir.org/fhir-all-xsd.zip'
    ]
    //     Downloading DSTU1 from http://hl7.org/fhir/DSTU1/fhir-all-xsd.zip
    // Generating DSTU1
    // Downloading DSTU2 from http://hl7.org/fhir/DSTU2/fhir-all-xsd.zip
    // Generating DSTU2
    // Downloading STU3 from http://hl7.org/fhir/STU3/fhir-all-xsd.zip
    // Generating STU3
    // Downloading Build from http://build.fhir.org/fhir-all-xsd.zip
    // Generating Build
    // Done
    public static function download(string $path)
    {
        if (Server::needsConfiguration()) {
            // download the zips
            $path = $this->validResourceLocations[$path] ?? "";
        }
    }

    public static function downloadDSTU1()
    {
        return static::download('http://hl7.org/fhir/DSTU1/fhir-all-xsd.zip');
    }

    public static function downloadDSTU2()
    {
        return static::download('http://hl7.org/fhir/DSTU2/fhir-all-xsd.zip');
    }
}

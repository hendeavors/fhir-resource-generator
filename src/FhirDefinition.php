<?php

namespace Endeavors\Fhir;

use Endeavors\Fhir\Server;

class FhirDefinition
{
    private static $definitions = [
        'schemaPath'  => __DIR__ . '/../input',
        'classesPath' => __DIR__ . '/../output',
        'versions' => [
            'DSTU1'  => ['url' => 'http://hl7.org/fhir/DSTU1/fhir-all-xsd.zip', 'namespace' => '\\HL7\\FHIR\\DSTU1'],
            'DSTU2'  => ['url' => 'http://hl7.org/fhir/DSTU2/fhir-all-xsd.zip', 'namespace' => '\\HL7\\FHIR\\DSTU2'],
            'STU3'   => ['url' => 'http://hl7.org/fhir/STU3/fhir-all-xsd.zip', 'namespace' => '\\HL7\\FHIR\\STU3'],
            'Build'  => ['url' => 'http://build.fhir.org/fhir-all-xsd.zip', 'namespace' => '\\HL7\\FHIR\\Build']
        ]
    ];
    //     Downloading DSTU1 from http://hl7.org/fhir/DSTU1/fhir-all-xsd.zip
    // Generating DSTU1
    // Downloading DSTU2 from http://hl7.org/fhir/DSTU2/fhir-all-xsd.zip
    // Generating DSTU2
    // Downloading STU3 from http://hl7.org/fhir/STU3/fhir-all-xsd.zip
    // Generating STU3
    // Downloading Build from http://build.fhir.org/fhir-all-xsd.zip
    // Generating Build
    // Done
    public static function download()
    {
        $versions = static::$definitions['versions'] ?? [];

        foreach(array_keys($versions) as $version) {
            echo 'Downloading ' . $version . ' from ' . $url . PHP_EOL;
            // Download/extract ZIP file
        //    copy($url, $zipFileName);
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

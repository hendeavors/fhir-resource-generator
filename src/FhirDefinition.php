<?php

namespace Endeavors\Fhir;

use Endeavors\Fhir\Server;
use Endeavors\Fhir\Support\RemoteFile;
use Endeavors\Fhir\Support\CompressedFile;
use Endeavors\Fhir\Support\File;
use Endeavors\Fhir\FhirClassGenerator;

class FhirDefinition
{
    private static $definitions = [
        'schemaPath'  => __DIR__ . '/../input',
        'classesPath' => __DIR__ . '/../output',
        'versions' => [
            'DSTU1'  => ['url' => 'http://hl7.org/fhir/DSTU1/fhir-all-xsd.zip'],
            'DSTU2'  => ['url' => 'http://hl7.org/fhir/DSTU2/fhir-all-xsd.zip'],
            'STU3'   => ['url' => 'http://hl7.org/fhir/STU3/fhir-all-xsd.zip'],
            'R4'     => ['url' => 'http://hl7.org/fhir/R4/fhir-all-xsd.zip'],
            'Build'  => ['url' => 'http://build.fhir.org/fhir-all-xsd.zip']
        ]
    ];

    public static function download(string $downloadVersion = null)
    {
        $versions = static::$definitions['versions'] ?? [];

        if (null !== $downloadVersion) {
            $versions = [$downloadVersion => static::$definitions['versions'][$downloadVersion] ?? static::$definitions['versions']['DSTU2']];
        }

        foreach($versions as $version => $path) {
            $remoteFile = RemoteFile::create($path['url']);
            $zipFileName = static::$definitions['schemaPath'] . DIRECTORY_SEPARATOR . $version . '.zip';
            echo 'Downloading ' . $version . ' from ' . ($path['url'] ?? "") . PHP_EOL;
            // Download/Extract zip file
            //CompressedFile::create()->extract($remoteFile->download(File::create($zipFileName)));

            $response = FhirClassGenerator::fromZip($remoteFile->download(File::create($zipFileName)))->generate();

            var_dump($response->get());
        }
    }

    public static function downloadSTU1()
    {
        static::download('DSTU1');
    }
}

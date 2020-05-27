<?php

namespace Endeavors\Fhir;

use Endeavors\Fhir\Server;
use Endeavors\Fhir\Support\RemoteFile;
use Endeavors\Fhir\Support\CompressedFile;
use Endeavors\Fhir\Support\File;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Contracts\FhirDefinitionVersionInterface;
use Endeavors\Fhir\Contracts\FhirDefinitionVersionLocationInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\NullOutput;
use Endeavors\Fhir\ConsoleGeneratorResponse;

class FhirDefinition implements FhirDefinitionVersionInterface
{
    private static $definitions = [
        'schemaPath'  => __DIR__ . '/../input',
        'classesPath' => __DIR__ . '/../output',
        'versions' => [
            self::VERSION_10  => ['url' => FhirDefinitionVersionLocationInterface::VERSION_10],
            self::VERSION_20  => ['url' => FhirDefinitionVersionLocationInterface::VERSION_20],
            self::VERSION_30   => ['url' => FhirDefinitionVersionLocationInterface::VERSION_30],
            self::VERSION_40     => ['url' => FhirDefinitionVersionLocationInterface::VERSION_40],
        ]
    ];

    public static function download(string $downloadVersion = null, OutputInterface $output = null)
    {
        if ($downloadVersion === self::VERSION_BUILD) {
            return;
        }
        
        $versions = static::$definitions['versions'] ?? [];

        if (null !== $downloadVersion) {
            $versions = [$downloadVersion => static::$definitions['versions'][$downloadVersion] ?? []];
        }

        foreach($versions as $version => $path) {
            $remoteFile = RemoteFile::create($path['url']);
            $zipFileName = static::$definitions['schemaPath'] . DIRECTORY_SEPARATOR . $version . '.zip';
            $response = FhirClassGenerator::fromZip(CompressedFile::create(), $remoteFile->download(File::create($zipFileName)))
            ->generate();

            if (null !== $output) {
                $response = new ConsoleGeneratorResponse($output, $response);
            }

            $response->print();
        }
    }

    public static function downloadFromConsole(string $downloadVersion = null)
    {
        return static::download($downloadVersion, new ConsoleOutput);
    }

    /**
     * Prevent output from interfering with http responses
     */
    public static function silentDownload(string $downloadVersion = null)
    {
        return static::download($downloadVersion, new NullOutput);
    }

    public static function downloadDSTU1(OutputInterface $output = null)
    {
        static::download(self::VERSION_10, $output);
    }

    public static function downloadDSTU2(OutputInterface $output = null)
    {
        static::download(self::VERSION_20, $output);
    }

    public static function downloadSTU3(OutputInterface $output = null)
    {
        static::download(self::VERSION_30, $output);
    }

    public static function downloadR4(OutputInterface $output = null)
    {
        static::download(self::VERSION_40, $output);
    }

    public static function downloadBuild(OutputInterface $output = null)
    {
        static::download(self::VERSION_BUILD, $output);
    }
}

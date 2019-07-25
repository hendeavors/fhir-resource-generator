<?php

namespace Endeavors\Fhir;

use Endeavors\Fhir\Support\XsdFileExtractor;
use DCarbone\PHPFHIR\ClassGenerator\Generator;
use RuntimeException;
use Exception;
use Throwable;
use Endeavors\Fhir\GeneratorException;
use Endeavors\Fhir\GeneratorResponse;
use Endeavors\Fhir\Support\Contracts\ZipExtractionInterface;
use Endeavors\Fhir\Support\ExistingFile;
use Endeavors\Fhir\Support\CompressedFile;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Server;

class FhirClassGenerator
{
    private $generator;

    public function __construct(string $directory)
    {
        // the path where the files were unzipped
        $directory = Directory::create($directory);

        if ($directory->doesntExist()) {
            throw InvalidDestinationDirectoryException::invalidDestinationDirectoryPath($directory);
        }

        $destination = Directory::create(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'output');

        $destination->make();

        $config = new \DCarbone\PHPFHIR\ClassGenerator\Config([
            'xsdPath' => $directory,
            'outputPath' => $destination,
            'outputNamespace' => 'Endeavors\HL7\Fhir\\' . $directory->name()
        ]);

        $this->generator = new Generator($config);
    }

    public static function create(string $directory)
    {
        return new static($directory);
    }

    public static function fromZip(string $zipFileName)
    {
        $directory = CompressedFile::create()->extractAll($zipFileName);

        return static::create($directory);
    }

    public function generate()
    {
        $ex = null;

        if (true) {
            try {
                $this->generator->generate();
            } catch (RuntimeException $e) {
                $ex = new GeneratorException($e->getMessage());
            } catch (Exception $e) {
                $ex = new GeneratorException($e->getMessage());
            } catch (Throwable $e) {
                $ex = new GeneratorException($e->getMessage());
            }
        }

        return new GeneratorResponse($ex);
    }
}

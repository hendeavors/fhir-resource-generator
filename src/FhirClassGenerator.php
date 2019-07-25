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

    private $destinationDirectory;

    private $directory;

    public function __construct(string $directory)
    {
        // the path where the files were unzipped
        $this->directory = Directory::create($directory);

        if ($this->directory->doesntExist()) {
            throw InvalidDestinationDirectoryException::invalidDestinationDirectoryPath($this->directory);
        }

        $this->destinationDirectory = Directory::create(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'output');

        $this->destinationDirectory->make();

        $config = new \DCarbone\PHPFHIR\ClassGenerator\Config([
            'xsdPath' => $this->directory,
            'outputPath' => $this->destinationDirectory,
            'outputNamespace' => 'Endeavors\HL7\Fhir\\' . $this->directory->name()
        ]);

        $this->generator = new Generator($config);
    }

    public static function create(string $directory)
    {
        return new static($directory);
    }

    public static function fromZip(CompressedFile $file, string $zipFileName)
    {
        return static::fromArchive($file, $zipFileName);
    }

    public static function fromArchive(CompressedFile $file, string $zipFileName)
    {
        return static::create($file->extractAll($zipFileName));
    }

    /**
     * @todo throw exception if already generated
     * @return GeneratorResponse
     */
    public function generate()
    {
        $ex = null;

        $message = 'Generator task has been run for ' . $this->directory->name() . '.';

        if ($this->generatedDirectoryDoesntExist()) {

            try {
                $this->generator->generate();
                $message = 'Generator task completed successfully for ' . $this->directory->name() . '.';
            } catch (RuntimeException $e) {
                $ex = new GeneratorException($e->getMessage());
            } catch (Exception $e) {
                $ex = new GeneratorException($e->getMessage());
            } catch (Throwable $e) {
                $ex = new GeneratorException($e->getMessage());
            }
        }

        return new GeneratorResponse($ex, $message);
    }

    private function generatedDirectoryDoesntExist(): bool
    {
        $directory = $this->destinationDirectory->get()
        . DIRECTORY_SEPARATOR
        . 'Endeavors'
        . DIRECTORY_SEPARATOR
        . 'HL7'
        . DIRECTORY_SEPARATOR
        . 'Fhir'
        . DIRECTORY_SEPARATOR
        . $this->directory->name();

        return Directory::create($directory)->doesntExist();
    }
}

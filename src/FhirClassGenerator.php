<?php

namespace Endeavors\Fhir;

use RuntimeException;
use Exception;
use Throwable;
use Endeavors\Fhir\FilesystemConfiguration;
use DCarbone\PHPFHIR\ClassGenerator\Generator;
use Endeavors\Fhir\GeneratorException;
use Endeavors\Fhir\GeneratorResponse;
use Endeavors\Fhir\Support\Contracts\ZipExtractionInterface;
use Endeavors\Fhir\InvalidSourceDirectoryException;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Server;

class FhirClassGenerator
{
    const GENERATOR_NAMESPACE = 'Endeavors\HL7\Fhir\\';

    private $generator;

    private $destinationDirectory;

    private $directory;

    public function __construct(string $directory)
    {
        // the path(source) where the files were unzipped
        $this->directory = Directory::create($directory);

        if ($this->directory->doesntExist()) {
            throw InvalidSourceDirectoryException::invalidSourceDirectoryPath($this->directory);
        }

        $this->destinationDirectory = Directory::create(FilesystemConfiguration::rootOutputDirectory());

        $this->destinationDirectory->make();

        $config = new \DCarbone\PHPFHIR\ClassGenerator\Config([
            'xsdPath' => $this->directory,
            'outputPath' => $this->destinationDirectory,
            'outputNamespace' => self::GENERATOR_NAMESPACE . $this->directory->name()
        ]);

        $this->generator = new Generator($config);
    }

    public static function create(string $directory)
    {
        return new static($directory);
    }

    public static function fromZip(ZipExtractionInterface $file, string $zipFileName)
    {
        return static::fromArchive($file, $zipFileName);
    }

    public static function fromArchive(ZipExtractionInterface $file, string $zipFileName)
    {
        // We extract all files even though it may not be necessary
        return static::create($file->extractAll($zipFileName));
    }

    /**
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
                $ex = new GeneratorException(sprintf("%s: %s", "Runtime Exception", $e->getMessage()));
            } catch (Exception $e) {
                $ex = new GeneratorException(sprintf("%s: %s", "General Exception", $e->getMessage()));
            } catch (Throwable $e) {
                $ex = new GeneratorException(sprintf("%s: %s", "Fatal Error", $e->getMessage()));
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

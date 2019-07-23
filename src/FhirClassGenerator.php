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
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Server;

class FhirClassGenerator
{
    private $generator;

    public function __construct(string $xsdPath)
    {
        // the path where the files were unzipped
        $directory = Directory::create($xsdPath);

        if ($directory->doesntExist()) {
            throw InvalidDestinationDirectoryException::invalidDestinationDirectoryPath($xsdPath);
        }

        $this->generator = new Generator($directory->get(), __DIR__ . DIRECTORY_SEPARATOR . 'output', 'Endeavors\Fhir');
    }

    public static function create(string $xsdPath)
    {
        return new static($xsdPath);
    }

    public static function fromZip(ZipExtractionInterface $extractor, string $sourceFile)
    {
        return static::create($extractor->extractAll($sourceFile));
    }

    public function generate()
    {

        // try extracting, if fails download from url?
        $ex = null;
        if (false) {
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

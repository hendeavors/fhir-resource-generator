<?php

namespace Endeavors\Fhir;

use Endeavors\Fhir\Support\XsdFileExtractor;
use DCarbone\PHPFHIR\ClassGenerator\Generator;
use RuntimeException;
use Exception;
use Throwable;
use Endeavors\Fhir\GeneratorException;
use Endeavors\Fhir\GeneratorResponse;

class FhirClassGenerator
{
    private $generator;

    public function __construct(string $xsdPath)
    {
        $this->generator = new Generator($xsdPath);
    }

    public function generate()
    {
        $ex = null;

        try {
            $this->generator->generate();
        } catch(RuntimeException $e) {
            $ex = new GeneratorException($e->getMessage());
        } catch(Exception $e) {
            $ex = new GeneratorException($e->getMessage());
        } catch(Throwable $e) {
            $ex = new GeneratorException($e->getMessage());
        }

        return new GeneratorResponse($ex);
    }
}

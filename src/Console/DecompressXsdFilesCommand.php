<?php

namespace Endeavors\Fhir\Console;

use Illuminate\Console\Command;

/**
 * The command will serve to decompress the compressed xsd files
 */
 // require __DIR__.'/vendor/autoload.php';
 //
 // $xsdPath = 'path to wherever you un-zipped the xsd files';
 //
 // $generator = new \DCarbone\PHPFHIR\ClassGenerator\Generator($xsdPath);
 //
 // $generator->generate();
class ResourceGenerationCommand extends Command
{
    private $extractor;

    public function __construct(ZipExtractionInterface $extractor = null)
    {
        $this->extractor = $extractor ?? XsdFileExtractor::create();
    }
}

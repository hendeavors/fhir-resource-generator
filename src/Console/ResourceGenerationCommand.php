<?php

namespace Endeavors\Fhir\Console;

use Illuminate\Console\Command;

/**
 * This command will serve to generate the fhir resources
 * As objects using the underlying library dcarbone/php-fhir
 * This command will required a path to the uncompressed files
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

}

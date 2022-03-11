<?php

namespace Endeavors\Fhir\Tests;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FhirDefinition;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Console\ResourceRemovalCommand;
use Endeavors\Fhir\Contracts\FhirDefinitionVersionInterface;

class AllResourceRemovalCommandTest extends TestCase
{
    protected function setUp(): void
    {
        FhirDefinition::downloadFromConsole();
    }

    /**
     * If no version option is supplied all versions should remove
     * @test
     */
    public function itRemoves()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceRemovalCommand;
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_BUILD)->doesntExist());
    }

    protected function getOutputDirectory()
    {
        $directory = __DIR__
        . DIRECTORY_SEPARATOR
        . '..'
        . DIRECTORY_SEPARATOR
        . 'output'
        . DIRECTORY_SEPARATOR
        . 'Endeavors'
        . DIRECTORY_SEPARATOR
        . 'HL7'
        . DIRECTORY_SEPARATOR
        . 'Fhir'
        . DIRECTORY_SEPARATOR;

        return $directory;
    }
}

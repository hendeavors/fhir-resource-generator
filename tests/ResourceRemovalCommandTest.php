<?php

namespace Endeavors\Fhir\Tests;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Console\ResourceRemovalCommand;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Contracts\FhirDefinitionVersionInterface;
use Endeavors\Fhir\FhirDefinition;

class ResourceRemovalCommandTest extends TestCase
{
    protected function setUp(): void
    {
        FhirDefinition::downloadFromConsole();
    }

    /**
     * Nothing should remove here
     * @test
     */
    public function failRemoveWithWrongVersion()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceRemovalCommand;
        $cmd->createOptionalInputFromSource(['--fhirversion' => 'foo']);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
    }

    /**
     * Only DSTU1 should remove
     * @test
     */
    public function removeDSTU1()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceRemovalCommand;
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_10]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
    }

    /**
     * Only DSTU2 should remove
     * @test
     */
    public function removeDSTU2()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceRemovalCommand;
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_20]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
    }

    /**
     * Only STU3 should remove
     * @test
     */
    public function removeSTU3()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceRemovalCommand;
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_30]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
    }

    /**
     * Only R4 should remove
     * @test
     */
    public function removeR4()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceRemovalCommand;
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_40]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
    }

    /**
     * Only BUILD should remove
     * @test
     */
    public function removeBuild()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceRemovalCommand;
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_BUILD]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
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

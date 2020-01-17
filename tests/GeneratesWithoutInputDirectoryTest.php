<?php

namespace Endeavors\Fhir\Tests;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FilesystemConfiguration;
use Endeavors\Fhir\Console\ResourceGenerationCommand;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Contracts\FhirDefinitionVersionInterface;

class GeneratesWithoutInputDirectoryTest extends TestCase
{
    /**
     * Generates resources with prior removal of directories
     * @test
     */
    public function generatesResourcesWithoutExistingDirectory()
    {
        $directory = FilesystemConfiguration::inputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->handle();

        Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->remove();
        Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->remove();
        Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->remove();
        Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->remove();
        Directory::create($directory . FhirDefinitionVersionInterface::VERSION_BUILD)->remove();

        $cmd = new ResourceGenerationCommand();
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_BUILD)->exists());
    }
}

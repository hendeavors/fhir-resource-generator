<?php

namespace Endeavors\Fhir\Tests;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\FilesystemConfiguration;
use Endeavors\Fhir\Console\ResourceGenerationCommand;
use Endeavors\Fhir\Console\ResourceRemovalCommand;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Contracts\FhirDefinitionVersionInterface;

class ResourceGenerationCommandTest extends TestCase
{
    /**
     * If no version option is supplied all versions should download
     * @test
     */
    public function downloadAll()
    {
        $directory = FilesystemConfiguration::outputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
    }

    /**
     * If no version option is supplied all versions should download
     * If not already downloaded
     * @test
     */
    public function downloadAllTwice()
    {
        $directory = FilesystemConfiguration::outputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->handle();
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
    }

    /**
     * Nothing should download here
     * @test
     */
    public function failDownloadWithWrongVersion()
    {
        $directory = FilesystemConfiguration::outputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => 'foo']);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
    }

    /**
     * Only DSTU1 should download
     * @test
     */
    public function downloadDSTU1()
    {
        $directory = FilesystemConfiguration::outputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_10]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
    }

    /**
     * Only DSTU2 should download
     * @test
     */
    public function downloadDSTU2()
    {
        $directory = FilesystemConfiguration::outputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_20]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
    }

    /**
     * Only STU3 should download
     * @test
     */
    public function downloadSTU3()
    {
        $directory = FilesystemConfiguration::outputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_30]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
    }

    /**
     * Only R4 should download
     * @test
     */
    public function downloadR4()
    {
        $directory = FilesystemConfiguration::outputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_40]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
    }

    /**
     * Only BUILD should download
     * @test
     */
    public function downloadBuild()
    {
        $directory = FilesystemConfiguration::outputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_BUILD]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
    }

    protected function tearDown(): void
    {
        Directory::create(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'input')->remove();
        (new ResourceRemovalCommand)->handle();
    }
}

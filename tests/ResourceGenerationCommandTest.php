<?php

namespace Endeavors\Fhir\Tests;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Console\ResourceGenerationCommand;
use Endeavors\Fhir\Console\ResourceRemovalCommand;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Contracts\FhirDefinitionVersionInterface;

class ResourceGenerationCommandTest extends TestCase
{
    protected function setUp()
    {
    }

    /**
     * If no version option is supplied all versions should download
     * @test
     */
    public function downloadAll()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_BUILD)->exists());
    }

    /**
     * If no version option is supplied all versions should download
     * If not already downloaded
     * @test
     */
    public function downloadAllTwice()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->handle();
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_BUILD)->exists());
    }

    /**
     * Nothing should download here
     * @test
     */
    public function failDownloadWithWrongVersion()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => 'foo']);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_BUILD)->doesntExist());
    }

    /**
     * Only DSTU1 should download
     * @test
     */
    public function downloadDSTU1()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_10]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_BUILD)->doesntExist());
    }

    /**
     * Only DSTU2 should download
     * @test
     */
    public function downloadDSTU2()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_20]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_BUILD)->doesntExist());
    }

    /**
     * Only STU3 should download
     * @test
     */
    public function downloadSTU3()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_30]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_BUILD)->doesntExist());
    }

    /**
     * Only R4 should download
     * @test
     */
    public function downloadR4()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_40]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->exists());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_BUILD)->doesntExist());
    }

    /**
     * Only BUILD should download
     * @test
     */
    public function downloadBuild()
    {
        $directory = $this->getOutputDirectory();

        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--fhirversion' => FhirDefinitionVersionInterface::VERSION_BUILD]);
        $cmd->handle();

        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_10)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_20)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_30)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_40)->doesntExist());
        $this->assertTrue(Directory::create($directory . FhirDefinitionVersionInterface::VERSION_BUILD)->exists());
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

    protected function tearDown()
    {
        Directory::create(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'input')->remove();
        (new ResourceRemovalCommand)->handle();
    }
}

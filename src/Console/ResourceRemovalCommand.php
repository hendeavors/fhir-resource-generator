<?php

namespace Endeavors\Fhir\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;
use Endeavors\Fhir\UnsupportedEnvironmentException;
use Endeavors\Fhir\Contracts\FhirDefinitionVersionInterface;
use Endeavors\Fhir\FhirClassGenerator;
use Endeavors\Fhir\Support\Directory;
use Endeavors\Fhir\Support\File;

/**
 * Removes the fhir resources.
 */
class ResourceRemovalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fhir:resources.clean {--fhirversion=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroys the zip fhir resources and php classes.';

    /**
     * Call another console command.
     * Executed by laravel.
     *
     * @param  string  $command
     * @param  array   $arguments
     * @return int
     */
    public function handle()
    {
        if (null === $this->input) {
            $this->createOptionalInputFromSource([]);
        }

        if (null === $this->input) {
            // unsupported
            throw new UnsupportedEnvironmentException("Environment not configured to support console input.");
        }

        $version = $this->option('fhirversion');

        $this->output = new ConsoleOutput;

        if ($version === FhirDefinitionVersionInterface::VERSION_10) {
            File::create($this->getRootImportDirectory() . $version . '.zip')->remove();
            Directory::create($this->getRootOutputDirectory() . $version)->remove();
        } elseif ($version === FhirDefinitionVersionInterface::VERSION_20) {
            File::create($this->getRootImportDirectory() . $version . '.zip')->remove();
            Directory::create($this->getRootOutputDirectory() . $version)->remove();
        } elseif ($version === FhirDefinitionVersionInterface::VERSION_30) {
            File::create($this->getRootImportDirectory() . $version . '.zip')->remove();
            Directory::create($this->getRootOutputDirectory() . $version)->remove();
        } elseif ($version === FhirDefinitionVersionInterface::VERSION_40) {
            File::create($this->getRootImportDirectory() . $version . '.zip')->remove();
            Directory::create($this->getRootOutputDirectory() . $version)->remove();
        } elseif ($version === FhirDefinitionVersionInterface::VERSION_BUILD) {
            File::create($this->getRootImportDirectory() . $version . '.zip')->remove();
            Directory::create($this->getRootOutputDirectory() . $version)->remove();
        } elseif (null === $version) {
            Directory::create($this->getRootImportDirectory())->remove();
            Directory::create($this->getRootOutputDirectory())->remove();
        } else {
            $this->error("Invalid fhirversion specified");
        }
    }

    /**
     * Create an input instance from the given arguments.
     *
     * @param  array  $arguments
     * @return \Symfony\Component\Console\Input\ArrayInput
     */
    public function createOptionalInputFromSource(array $arguments)
    {
        $definition = new InputDefinition([
            new InputOption('fhirversion', 'fv', InputOption::VALUE_OPTIONAL),
        ]);

        if (count($arguments) === 0) {
            $this->input = $input = new ArrayInput([], $definition);

            return $this->input;
        }

        $this->input = $input = new ArrayInput($arguments, $definition);

        return $this->input;
    }

    protected function getRootImportDirectory()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'input' . DIRECTORY_SEPARATOR;
    }

    protected function getRootOutputDirectory()
    {
        return __DIR__
        . DIRECTORY_SEPARATOR
        . '..'
        . DIRECTORY_SEPARATOR
        . '..'
        . DIRECTORY_SEPARATOR
        . 'output'
        . DIRECTORY_SEPARATOR
        . str_replace('\\', DIRECTORY_SEPARATOR, rtrim(FhirClassGenerator::GENERATOR_NAMESPACE, "/\\")) . DIRECTORY_SEPARATOR;
    }
}

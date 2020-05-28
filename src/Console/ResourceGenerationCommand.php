<?php

namespace Endeavors\Fhir\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;
use Endeavors\Fhir\UnsupportedEnvironmentException;
use Endeavors\Fhir\FhirDefinition;

/**
 * This command will serve to generate the fhir resources
 * As objects using the underlying library dcarbone/php-fhir
 * This will download the file definitions, respectively,
 * Unzip them to a specified directory corresponding to
 * The fhir verions, and proceed to generate the fhir
 * Definitions as PHP classes.
 */
class ResourceGenerationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fhir:resources.generate {--fhirversion=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate fhir resources as PHP classes';

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

        if ($version === FhirDefinition::VERSION_10) {
            FhirDefinition::downloadDSTU1($this->output);
        } elseif ($version === FhirDefinition::VERSION_20) {
            FhirDefinition::downloadDSTU2($this->output);
        } elseif ($version === FhirDefinition::VERSION_30) {
            FhirDefinition::downloadSTU3($this->output);
        } elseif ($version === FhirDefinition::VERSION_40) {
            FhirDefinition::downloadR4($this->output);
        } elseif (null === $version) {
            FhirDefinition::downloadFromConsole();
        } else {
            $this->error("Invalid fhirversion specified");
        }

        return 0;
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
}

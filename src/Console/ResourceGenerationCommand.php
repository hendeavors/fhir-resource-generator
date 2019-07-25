<?php

namespace Endeavors\Fhir\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;
use Illuminate\Support\Str;

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
 //
class ResourceGenerationCommand extends Command
{
    public function __construct()
    {
        parent::__construct();

        $this->output = $this->output ?? new ConsoleOutput;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fhir:resources.generate {--version=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate fhir resources as PHP classes';

    /**
     * Call another console command.
     *
     * @param  string  $command
     * @param  array   $arguments
     * @return int
     */
    public function handle()
    {
        if (null === $this->input) {
            // unsupported
            throw new \Exception("Environment not configured to support console input");
        }
        // Will work from within Laravel context
        // Otherwise invoke createOptionalInputFromSource
        // Prior to invoking handle
        $version = $this->option('version');

        if ($version === "DSTU1") {
            \Endeavors\Fhir\FhirDefinition::downloadSTU1();
        } else {
            \Endeavors\Fhir\FhirDefinition::download();
        }
    }

    public function useConsole()
    {
        $this->output = $this->output ?? new ConsoleOutput;

        return $this;
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
            new InputOption('version', 'v', InputOption::VALUE_OPTIONAL),
        ]);

        $this->input = $input = new ArrayInput($arguments, $definition);

        return $this->input;
    }
}

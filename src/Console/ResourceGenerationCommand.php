<?php

namespace Endeavors\Fhir\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;
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
    protected $signature = 'fhir:resources.generate';

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
    public function call($command, array $arguments = [])
    {
        $this->info('Display this on the screen');

        $output = '';

        foreach($this->commandStrings() as $commandString) {
            $executionString = 'php ' . $commandString;
            $output = shell_exec($executionString);

            if (Str::contains($output, 'Could not open input file')) {
                $this->error('Could not open input file' . $commandString);
            }
        }



        dd($output);

        parent::call($command, $arguments);
    }

    protected function commandStrings()
    {
        return ['../../../../vendor/dcarbone/php-fhir/bin/generate.php', '../../../vendor/dcarbone/php-fhir/bin/generate.php', __DIR__ . '/../../vendor/dcarbone/php-fhir/bin/generate.php'];
    }
}

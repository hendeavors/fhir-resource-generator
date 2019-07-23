<?php

namespace Endeavors\Fhir\Tests;

use PHPUnit\Framework\TestCase;
use Endeavors\Fhir\Resources\DSTU2\Conformance;
use Endeavors\Fhir\Console\ResourceGenerationCommand;
use Illuminate\Console\Application as ConsoleApplication;
use Endeavors\Fhir\Tests\LaravelTestContainer;
use Endeavors\Fhir\Tests\LaravelTestDispatcher;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\NullOutput;

class ResourceGenerationCommandTest extends TestCase
{
    protected function setUp()
    {
    }

    /**
     * @test
     */
    public function parseFromJsonFile()
    {
        $laravel = new LaravelTestContainer();
        $dispatcher = new LaravelTestDispatcher();
        $cmd = new ResourceGenerationCommand();
        //$cmd->setLaravel($laravel);
        $consoleApplication = new ConsoleApplication($laravel, $dispatcher, 'TEST');
        $consoleApplication->add($cmd);
        //$cmd->setApplication($consoleApplication);
        $cmd->call('fhir:resources.generate');
        //dd($cmd->getOutput());
    }

    protected function runCommand($command, $input = [])
    {
        return $command->run(new ArrayInput($input), new ConsoleOutput);
    }

    protected function runSilentCommand($command, $input = [])
    {
        return $command->run(new ArrayInput($input), new ConsoleOutput);
    }

    protected function tearDown()
    {
    }
}

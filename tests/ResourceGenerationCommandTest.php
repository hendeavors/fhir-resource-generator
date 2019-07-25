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

    public function downloadAll()
    {
        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--version' => 'foo']);
        $cmd->handle();
    }

    /**
     * @test
     */
    public function downloadSTU1()
    {
        $cmd = new ResourceGenerationCommand();
        $cmd->createOptionalInputFromSource(['--version' => 'DSTU1']);
        $cmd->handle();
    }

    protected function tearDown()
    {
    }
}
